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



    public function newsletter()
    {
        $mails ='';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $validator = new MailController();
            $output = $validator->mail();
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
