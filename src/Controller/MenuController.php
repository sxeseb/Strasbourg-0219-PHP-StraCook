<?php


namespace App\Controller;

use App\Model\MenuManager;

class MenuController extends AbstractController
{
    public function menus()
    {
        return $this->twig->render('Menu/menus.html.twig');
    }

    public function show(int $id)
    {
        $MenuManager = new MenuManager();
        $menu = $MenuManager->selectOneById($id);

        return $this->twig->render('Menu/show.html.twig', ['menu' => $menu]);
    }

    public function list()
    {
        $MenuManager = new MenuManager();
        $menus = $MenuManager->selectAll();

        return $this->twig->render('Menu/list.html.twig', ['menus' => $menus]);
    }
}
