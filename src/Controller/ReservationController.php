<?php


namespace App\Controller;

use App\Model\ReservationManager;
use App\Service\ValidationController;

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

    public function control(array $post)
    {
        $validator = new ValidationController();
        $data = $validator->checkResa($post);
    }
}
