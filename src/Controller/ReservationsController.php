<?php


namespace App\Controller;

use App\Model\ReservationsManager;

class ReservationsController extends AbstractController
{
    public function reserver()
    {
        return $this->twig->render('Reservations/reserver.html.twig');
    }

    public function list()
    {
        $resaManager = new ReservationsManager();
        $reservations = $resaManager->selectAll();
        return $this->twig->render('Reservations/list.html.twig', ['reservations' => $reservations]);
    }

    public function show(int $id)
    {
        $resaManager = new ReservationsManager();
        $reservation =  $resaManager->selectOneById($id);
        return $this->twig->render('Reservations/show.html.twig', ['reservation' => $reservation]);
    }
}
