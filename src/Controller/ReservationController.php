<?php


namespace App\Controller;

use App\Model\MenuManager;
use App\Model\ReservationManager;
use App\Model\UsersManager;
use App\Service\CartService;
use App\Service\DateService;
use App\Service\ValidationService;
use App\Model\OrdersManager;

class ReservationController extends AbstractController
{
    public function reserver()
    {
        if (isset($_SESSION['emailConfirmation'])) {
            unset($_SESSION['emailConfirmation']);
        }

        $menuManager = new MenuManager();
        $menus = $menuManager->selectAllMenus();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $validator = new CartService();
            $output = $validator->addToCart();
            list($errors, $datas) = $output;
        }

        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            $cartService = new CartService();
            $panier = $_SESSION['cart'];
            $count = $cartService->calculTotal($panier);

            return $this->twig->render(
                'Reservations/reserver.html.twig',
                ['menus' => $menus, 'panier' => $panier, 'count' => $count]
            );
        } else {
            return $this->twig->render('Reservations/reserver.html.twig', ['menus' => $menus]);
        }
    }

    public function list()
    {
        $resaManager = new ReservationManager();
        $reservations = $resaManager->selectAll();
        return $this->twig->render('Reservations/list.html.twig', ['reservations' => $reservations]);
    }

    public function show(int $id)
    {
        $resaManager = new ReservationManager();
        $reservation =  $resaManager->selectOneById($id);
        return $this->twig->render('Reservations/show.html.twig', ['reservation' => $reservation]);
    }

    public function success()
    {
        if (isset($_SESSION['emailConfirmation'])) {
            $email = $_SESSION['emailConfirmation'];
            return $this->twig->render('Reservations/success.html.twig', ['email' => $email]);
        } else {
            header('location: /reservation/reserver');
        }
    }

    public function checkCart()
    {
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            $validator = new ValidationService();
            $output = $validator->checkCart();
            list($errors, $resaDatas) = $output;
            if (empty($errors)) {
                $_SESSION['resaDatas'] = $resaDatas;
                header('location: /users/infos');
            } else {
                header('location: /reservation/reserver');
            }
        }
    }

    public function validReservation($userDatas)
    {
        $userManager = new UsersManager();
        $emailId = $userManager->insertMail($userDatas);
        if ($emailId) {
            $_SESSION['emailConfirmation'] = $userDatas['email'];
        }

        // insertion user
        $userId = $userManager->insert($userDatas, $emailId);

        // insertion reservation
        $date = new \DateTime($_SESSION['resaDatas']['date']);
        $date = $date->setTime($_SESSION['resaDatas']['arrival'], 0, 0);
        $date = $date->format('Y-m-d H:i:s');
        $_SESSION['resaDatas']['date_booked'] = $date;
        $resaDatas = $_SESSION['resaDatas'];

        $resaManager = new ReservationManager();
        $resaId = $resaManager->insert($resaDatas, $userId);

        // insertion orders
        $orderManager = new OrdersManager();

        foreach ($_SESSION['cart'] as $order) {
            $orderId = $orderManager->insert($order, $resaId);
        }


        if ($emailId && $userId && $resaId) {
            unset($_SESSION['cart']);
            unset($_SESSION['resaDatas']);
            unset($_POST);

            return 1;
        } else {
            return -1;
        }
    }

    public function reservations(int $id = null)
    {
        $resaManager = new ReservationManager();
        $overviewsPending = $resaManager->reservationPending();
        $confirmed = $resaManager->reservationConfirmed();
        $dateService = new DateService();

        // formatage des données date et heure
        $overviewsPending = $dateService->setToFormat($overviewsPending);
        $confirmed = $dateService->setToFormat($confirmed);

        if (isset($id) && is_int($id)) {
            $clientDetails = $resaManager->reservationDetails($id);
            $orderDetails = $resaManager->reservationOrderDetails($id);
            return $this->twig->render(
                'Admin/reservations.html.twig',
                ['pending' => $overviewsPending,
                    'orderDetails' => $orderDetails, 'clientDetails' => $clientDetails, 'confirmed' => $confirmed]
            );
        }

        return $this->twig->render(
            'Admin/reservations.html.twig',
            ['pending' => $overviewsPending, 'confirmed' => $confirmed]
        );
    }

    public function confirm(int $id) :void
    {
        $reservationManager = new ReservationManager();
        if ($reservationManager->confirm($id)) {
            header('location: /reservation/reservations');
        }
    }


    public function decline(int $id) :void
    {
        $ordersManager = new OrdersManager();
        $ordersManager->delete($id);
        $reservationManager = new ReservationManager();
        $reservationManager->decline($id);
        header('location: /reservation/reservations');
    }
}
