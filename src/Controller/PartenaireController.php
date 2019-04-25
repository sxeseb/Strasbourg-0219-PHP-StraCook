<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */
namespace App\Controller;

class PartenaireController extends AbstractController
{
    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function partenaire()
    {
        $partenaire new partenaire;
        return $this->twig->render('Partenaire/partenaire.html.twig', ['partenaires' => $partenaire]);
    }
}
