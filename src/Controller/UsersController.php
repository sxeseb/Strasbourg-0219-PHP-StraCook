<?php


namespace App\Controller;

use App\Model\ReservationManager;
use App\Model\UsersManager;
use App\Service\ValidationService;

class UsersController extends AbstractController
{
    public function infos()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $validator = new ValidationService();
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
                 *
                */
                // insertion email

                $userManager = new UsersManager();
                $emailId = $userManager->insertMail($userDatas);

                // insertion user
                $userId = $userManager->insert($userDatas, $emailId);

                // insertion reservation
                $date = new \DateTime($_SESSION['resaDatas']['date']);
                $date = $date->format('Y-m-d');
                $_SESSION['resaDatas']['date_booked'] = $date;
                $resaDatas = $_SESSION['resaDatas'];

                $resaManager = new ReservationManager();
                $resaId = $resaManager->insert($resaDatas, $userId);

                if ($emailId && $userId && $resaId) {
                    unset($_SESSION);
                    unset($_POST);
                    header('location: /reservation/success');
                }

                /*
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
