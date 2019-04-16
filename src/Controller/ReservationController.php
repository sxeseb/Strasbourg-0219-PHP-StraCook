<?php


namespace App\Controller;

use App\Model\ReservationManager;
use App\Service\ValidationController;

class ReservationController extends AbstractController
{
    public function reserver()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $validator = new ValidationController();
            $output = $validator->checkResa();
            list($errors, $datas) = $output;
            if (!empty($errors)) {
                return $this->twig->render('Reservations/reserver.html.twig', ['errors' => $errors, 'datas' => $datas]);
            } else {
                // insertion user
                // récupérer id pour insertion reservation

                $user_id = '';
                /*
                // insertion reservation
                $resaManager = new ReservationManager();
                $resaManager->insert($_POST, $user_id);
                header('location: /home/index');*/
            }
        }
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
