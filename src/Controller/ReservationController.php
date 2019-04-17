<?php


namespace App\Controller;

use App\Model\ReservationManager;
use App\Service\ValidationController;

class ReservationController extends AbstractController
{
    public function reserver()
    {

        // select all menus pour affichage dynamique
        /*
        $menuManager = new MenuManager();
        $menus = $menuManager->selectAllMenus();
        */
        $menus ='';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $validator = new ValidationController();
            $output = $validator->checkResa();
            list($errors, $userDatas) = $output;
            if (!empty($errors)) {
                return $this->twig->render(
                    'Reservations/reserver.html.twig',
                    ['menus' => $menus, 'errors' => $errors, 'user_datas' => $userDatas]
                );
            } else {
                /*
                 * TODO création des manager et controller pour Order et User
                // insertion user
                $userManager = new UserManager();
                $userId = $userManager->insert($userDatas);

                // insertion reservation
                $resaManager = new ReservationManager();
                $resaId = $resaManager->insert($resaDatas, $userId);


                // insertion orders
                $orderManager = new OrderManager();
                $orderId = $orderManager->insert($orderDatas, $resaID, $userId);

                if ($userID && $resaId && $orderId) {
                    header('location: /reservation/success');
                }
                */
            }
        }
        return $this->twig->render('Reservations/reserver.html.twig', ['menus' => $menus]);
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
