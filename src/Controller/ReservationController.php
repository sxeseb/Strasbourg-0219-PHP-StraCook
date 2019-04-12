<?php


namespace App\Controller;

use App\Model\ReservationManager;

class ReservationController extends AbstractController
{
    public function reserver()
    {
        return $this->twig->render('Reservations/reserver.html.twig');
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
}
