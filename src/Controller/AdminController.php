<?php
/**
 * Created by PhpStorm.
 * User: Sylvain
 * Date: 2019-04-30
 * Time: 11:14
 */

namespace App\Controller;

use App\Model\OrdersManager;
use App\Model\ReservationManager;
use App\Service\DateService;
use App\Service\ValidationService;

class AdminController extends AbstractController
{
    public function admin()
    {
        header('location: /admin/dashboard');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $validator = new ValidationService();
            $output = $validator->checkAdmin();
            list($errors, $datas) = $output;

            if (!empty($errors)) {
                return $this->twig->render('Admin/login.html.twig', ['errors' => $errors]);
            } else {
                $_SESSION['admin'] = $datas['user'];
                header('location: /admin/dashboard');
            }
        }

        if (!isset($_SESSION['admin']) || empty($_SESSION['admin']) || $_SESSION['admin'] != 'admin') {
            return $this->twig->render('Admin/login.html.twig');
        } else {
            header('location: /admin/dashboard');
        }
    }

    public function logout()
    {
        unset($_SESSION['admin']);
        header('location: /admin/login');
    }

    public function dashboard()
    {
        if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
            header('location: /admin/login');
        }
        return $this->twig->render('Admin/dashboard.html.twig');
    }

    public function reservations(int $id = null)
    {

        if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
            header('location: /admin/login');
        }

        $resaManager = new ReservationManager();
        $overviewsPending = $resaManager->reservationPending();
        $confirmed = $resaManager->reservationConfirmed();
        $dateService = new DateService();

        // formatage des données date et heure
        $overviewsPending = $dateService->setToFormat($overviewsPending);
        $confirmed = $dateService->setToFormat($confirmed);

        if (isset($id) && is_int($id)) {
            $clientDetails = $resaManager->reservationDetails($id);
            $clientDetails['daysToDate'] = $dateService->daysToNow($clientDetails['date_resa']);
            list($date, $time) = $dateService->formatFromDb($clientDetails['date_resa']);
            $clientDetails['date'] = $date;
            $clientDetails['time'] = $time;
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

    // refus de la réservation :  envoi d'un email de refus
    public function decline(int $id) :void
    {
        $ordersManager = new OrdersManager();
        $ordersManager->delete($id);
        $reservationManager = new ReservationManager();
        $reservationManager->decline($id);
        header('location: /reservation/reservations');
    }

    // annulation de la réservation : email d'annulation et proposition d'autres dates
    public function cancel(int $id) :void
    {
        $ordersManager = new OrdersManager();
        $ordersManager->delete($id);
        $reservationManager = new ReservationManager();
        $reservationManager->decline($id);
        header('location: /reservation/reservations');
    }
}
