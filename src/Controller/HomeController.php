<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */
namespace App\Controller;

use App\Model\MenuManager;

class HomeController extends AbstractController
{
    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $menumanager= new MenuManager();
        $menus=$menumanager -> selectAllMenus();
        return $this->twig->render('Home/index.html.twig', ['menus' => $menus]);
    }
    public function index1()
    {
        $part = ['part1', 'part2', 'part3'];
        return $this->twig->render('Home/index.html.twig', ['part' => $part]);
    }
    public function about()
    {
        return $this->twig->render('Home/propos.html.twig');
    }
}
