<?php

namespace App\Controller;

use App\Model\AdminMenuManager;

class AdminController extends AbstractController
{
    private $menumanager;
    public function AdminMenu()
    {
        $menumanager = new AdminMenuManager();
        $menus = $menumanager ->selectAllMenus();
        return $this->twig->render('Admin/AdminMenu.html.twig',['menus' => $menus]);
    }
    public function ItemManagement()
    {
        return $this->twig->render('Admin/ItemManagement.html.twig');
    }

    public function Datatreatment()
    {
        $menumanager = new AdminMenuManager();

        $NomMenu=$_POST["nom_menu"];
        $starter=$_POST["entree"];
        $mainCourse=$_POST["plat"];
        $dessert=$_POST["dessert"];
        $desc=$_POST["description"];
        $url="";
        if(isset($_POST["fileToUpload"]) && !empty($_POST["fileToUpload"]))
        {
         $url=$_POST["fileToUpload"];
         $url2=$url;
         $urlSplit=explode("/",$url);
         $imgName=end($urlSplit);
      
        copy($url, '/home/julien/Bureau/projet2/Strasbourg-0219-PHP-StraCook/public/assets/images/menus/'.$imgName);
        }
      if($menumanager ->insert($NomMenu,$starter,$mainCourse,$dessert,$desc,$url)==1)
        {
            $this->AdminMenu();
        }  
        else{
            echo "L'insert a échoué...";
        }
    }
}
