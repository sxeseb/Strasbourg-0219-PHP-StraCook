<?php


namespace App\Controller;

use App\Model\MenuManager;
use App\Model\ReservationManager;
use App\Service\CartService;

class ReservationController extends AbstractController
{
    public function reserver()
    {
        $menuManager = new MenuManager();
        $menus = $menuManager->selectAllMenus();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $validator = new CartService();
            $output = $validator->addToCart();
            list($errors, $datas) = $output;
        }

        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            $cartService = new CartService();
            $panier = $_SESSION['cart'];
            $count = $cartService->calculTotal($panier);

            return $this->twig->render(
                'Reservations/reserver.html.twig',
                ['menus' => $menus, 'panier' => $panier, 'count' => $count]
            );
        } else {
            return $this->twig->render('Reservations/reserver.html.twig', ['menus' => $menus]);
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
