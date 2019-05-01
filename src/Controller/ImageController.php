<?php


namespace App\Controller;

use App\Model\ImageManager;
use App\Service\ValidationService;

class ImageController extends AbstractController
{
    public function menus()
    {
        $menumanager = new ImageManager();
        $menus = $menumanager ->selectAll();
        return $this->twig->render('Menu/menus.html.twig', ['menus' => $menus]);
    }

    public function delete(int $id):void
    {

        $deleteimage = new ImageManager();
        $deleteimage->deleteAllImage($id);
        if ($deleteimage -> deleteAllImage($id)) {
            header('location: /menu/adminmenu/');
        }
    }

    public function updateImage(int $id)
    {
        $imagemenu = new ImageManager();
        $images = $imagemenu ->selectAllImages($id);
        return $this->twig->render('Admin/menuedit.html.twig', ['menu' => $images]);
    }
}
