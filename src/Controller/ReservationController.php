<?php


namespace App\Controller;

use App\Model\MenuManager;
use App\Model\ReservationManager;
use App\Service\CartController;

class ReservationController extends AbstractController
{
    public function reserver()
    {
        $menuManager = new MenuManager();
        $menus = $menuManager->selectAllMenus();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $validator = new CartController();
            $output = $validator->addToCart();
            list($errors, $datas) = $output;
            if (empty($errors)) {
                $_SESSION['cart'][] = $datas;
            }
        }

        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            $panier = $_SESSION['cart'];




            return $this->twig->render('Reservations/reserver.html.twig', ['menus' => $menus, 'panier' => $panier]);
        } else {
            return $this->twig->render('Reservations/reserver.html.twig', ['menus' => $menus]);
        }
    }


    public function addToCart()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $validator = new CartController();
            $output = $validator->addToCart();
            list($errors, $datas) = $output;
            if (empty($errors)) {
                $_SESSION['cart'][] = $datas;
            }
            return $this->reserver();
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
        return $this->twig->render('Reservations/success.html.twig');
    }
}
