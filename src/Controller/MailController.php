<?php


namespace App\Controller;

use App\Model\MailManager;

class MailController extends AbstractController
{
    public function mail()
    {
        $mailmanager = new MailManager();
        $mails = $mailmanager->insertMail(['mail' => $mailmanager]);
        return $this->twig->render('Home/index.html.twig', ['mail' => $mails]);
    }
}
