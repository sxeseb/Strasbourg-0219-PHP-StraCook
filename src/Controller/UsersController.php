<?php


namespace App\Controller;

use App\Service\ValidationController;

class UsersController extends AbstractController
{
    public function infos()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $validator = new ValidationController();
            $output = $validator->checkCoord();
            list($errors, $userDatas) = $output;
            if (!empty($errors)) {
                return $this->twig->render(
                    'Users/infos.html.twig',
                    ['errors' => $errors, 'datas' => $userDatas]
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

                if ($userId && $resaId && $orderId) {
                    header('location: /reservation/success');
                }
                */
            }
        }
        return $this->twig->render('Users/infos.html.twig');
    }
}
