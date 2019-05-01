<?php


namespace App\Controller;

use App\Model\ImageManager;
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
        $menus = $adminmenu ->selectAllMenus();
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

    public function deleteOneImage(int $id):void
    {
        $deleteimage = new ImageManager();
        if ($deleteimage ->deleteOneImage($id)) {
            header('location: /menu/adminmenu/');
        }
    }

    public function updateMenu(int $id)
    {
        $adminmenu = new MenuManager();
        $menus = $adminmenu ->selectOneMenus($id);
        $imagesmenu = new ImageManager();
        $images = $imagesmenu -> selectAllImages($id);
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
                $menuManager = new MenuManager();
                if ($menuManager -> updateMenu($menuDatas, $id)) {
                    unset($_POST);
                    header('location: /menu/adminmenu');
                }
            }
        }

        return $this->twig->render('Admin/menuedit.html.twig', ['menu' => $menus, 'images'=>$images]);
    }

    public function updateImage(int $id)
    {
        $imagesmenu = new ImageManager();
        $images = $imagesmenu -> selectAllImages($id);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $validatorImage = new ValidationService();
            $outputimage = $validatorImage->checkImage();
            list($imageErrors, $imageDatas) = $outputimage;
            if (!empty($imagesErrors)) {
                return $this->twig->render(
                    'Admin/menuedit.html.twig',
                    ['errors' => $imageErrors, 'image' => $imageDatas]
                );
            } else {
                $imageManager = new ImageManager();
                if ($imageManager->updateImage($imageDatas, $id)) {
                    unset($_POST);
                    header('location: /menu/menuedit');
                }
            }
        }
        return $this->twig->render('Admin/menuedit.html.twig', ['images' => $images]);
    }

    public function addMenu()
    {
        $addmenu = new MenuManager();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $validator = new ValidationService();
            $output = $validator->checkMenu();
            list($errors, $menuDatas) = $output;
            if (!empty($errors)) {
                return $this->twig->render(
                    'Admin/menuadd.html.twig',
                    ['errors' => $errors, 'menu' => $menuDatas]
                );
            } else {
                $menuManager = new MenuManager();
                if ($menuManager -> addmenu($menuDatas)) {
                    unset($_POST);
                    header('location: /menu/adminmenu');
                }
            }
        }

        return $this->twig->render('Admin/menuadd.html.twig');
    }

    public function addImage()
    {
        $addimage = new ImageManager();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $validatorImage = new ValidationService();
            $outputimage = $validatorImage->checkImage();
            list($imageErrors, $imageDatas) = $outputimage;
            if (!empty($imageErrors)) {
                return $this->twig->render(
                    'Admin/menuedit.html.twig',
                    ['errors' => $imageErrors, 'image' => $imageDatas]
                );
            } else {
                $imageManager = new ImageManager();
                if ($imageManager->addImage($imageDatas)) {
                    unset($_POST);
                    header('location: /menu/adminmenu');
                }
            }
        }
        return $this->twig->render('Admin/menuedit.html.twig');
    }
}
