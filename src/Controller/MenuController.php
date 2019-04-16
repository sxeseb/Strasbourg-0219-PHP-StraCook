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
        $menuManager = new MenuManager();
        $menu = $menuManager->selectOneById($id);

        return $this->twig->render('Menu/show.html.twig', ['menu' => $menu]);
    }

    public function list()
    {
        $menuManager = new MenuManager();
        $menus = $menuManager->selectAll();

        return $this->twig->render('Menu/list.html.twig', ['menus' => $menus]);
    }
}
