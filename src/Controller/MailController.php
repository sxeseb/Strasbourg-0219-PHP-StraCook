<?php


namespace App\Controller;

use App\Model\MailManager;

class MailController extends AbstractController
{
    public function mail()
    {
        $mailmanager = new MailManager();
        $mails = $mailmanager ->selectAll();
        return $this->twig->render('Home/index.html.twig', ['mail' => $mails]);
    }

    public function checkMail()
    {
        $errors = [];
        $datas = [];
        $mails = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_POST['email']) || empty($_POST['email'])) {
                $errors['email'] = 'Veuillez renseigner le champs email';
            } elseif (!preg_match(
                "/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/",
                $_POST['email']
            )) {
                $errors['email'] = 'Veuillez saisir un email valide';
            } else {
                $datas['email'] = $this->testInput($_POST['email']);
            }
        }
        return $this->twig->render('Home/index.html.twig', ['mail' => $mails]);
    }

    public function newsletter()
    {
        $mails ='';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $validator = new MailController();
            $output = $validator->checkMail();
            list($errors, $datas) = $output;
            if (!empty($errors)) {
                return $this->twig->render(
                    'Home/index.html.twig',
                    ['mail' => $mails, 'errors' => $errors, 'datas' => $datas]
                );
            } else {
                // insertion mail

                $mails = '';
            }
        }
        return $this->twig->render('Home/index.html.twig', ['mail' => $mails]);
    }
}
