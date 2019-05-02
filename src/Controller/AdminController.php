<?php
/**
 * Created by PhpStorm.
 * User: Sylvain
 * Date: 2019-04-30
 * Time: 11:14
 */

namespace App\Controller;

use App\Model\OrdersManager;
use App\Model\MenuManager;
use App\Model\ReservationManager;
use App\Service\DateService;

class AdminController extends AbstractController
{
    public function dashboard()
    {
        return $this->twig->render('Admin/dashboard.html.twig');
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

    public function adminmenu()
    {
        $adminmenu = new MenuManager();
        $menus = $adminmenu ->selectAllMenus();
        return $this->twig->render('Admin/menu.html.twig', ['menus' => $menus]);
    }
}
