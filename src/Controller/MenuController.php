<?php


namespace App\Controller;

use App\Model\MenuManager;
use App\Service\ValidationService;

class MenuController extends AbstractController
{
    public function menus()
    {
        $menumanager = new MenuManager();
        $menus = $menumanager ->selectAll();
        return $this->twig->render('Menu/menus.html.twig', ['menus' => $menus]);
    }

    public function show(int $id)
    {
        $menuManager = new MenuManager();
        $menu = $menuManager->selectOneMenus($id);
        $images = $menuManager->selectAllImages($id);

        return $this->twig->render('Menu/show.html.twig', ['menu' => $menu, 'images' => $images]);
    }

    public function list()
    {
        $menuManager = new MenuManager();
        $menus = $menuManager->selectAll();

        return $this->twig->render('Menu/list.html.twig', ['menus' => $menus]);
    }

    public function adminmenu()
    {
        $adminmenu = new MenuManager();
        $menus = $adminmenu ->selectAll();
        return $this->twig->render('Admin/menu.html.twig', ['menus' => $menus]);
    }

    public function delete(int $id):void
    {

        $deletemenu = new MenuManager();
        $deletemenu->deleteAllImage($id);
        if ($deletemenu ->delete($id)) {
            header('location: /menu/adminmenu/');
        }
    }

    public function editmenu()
    {
        $adminmenu = new MenuManager();
        $menus = $adminmenu ->selectAll();
        return $this->twig->render('Admin/menuedit.html.twig', ['menus' => $menus]);
    }

    public function updateMenu(int $id)
    {
        $adminmenu = new MenuManager();
        $menus = $adminmenu ->selectOneMenus($id);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $validator = new ValidationService();
            $output = $validator->checkMenu();
            list($errors, $menuDatas) = $output;
            if (!empty($errors)) {
                return $this->twig->render(
                    'Admin/menuedit.html.twig',
                    ['errors' => $errors, 'menu' => $menus]
                );
            } else {
                // appel du controller de reservation pour lancer la procédure d'insertion
                $menuManager = new MenuManager();
                if ($menuManager -> updateMenu($menuDatas, $id)) {
                    header('location: /menu/adminmenu');
                }
            }
        }

        return $this->twig->render('Admin/menuedit.html.twig', ['menu' => $menus]);
    }

    public function updateImage($img_src)
    {
        $updateimage = new MenuManager();
        if ($updateimage ->updateImage($img_src)) {
            header('location: /menu/editmenu/');
        }
    }
}
