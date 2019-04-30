<?php
/**
 * Created by PhpStorm.
 * User: Sylvain
 * Date: 2019-04-30
 * Time: 11:14
 */

namespace App\Controller;

class AdminController extends AbstractController
{
    public function dashboard()
    {
        return $this->twig->render('Admin/dashboard.html.twig');
    }
}
