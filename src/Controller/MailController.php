<?php


namespace App\Controller;

use App\Model\MailManager;

class MailController extends AbstractController
{
    public function mail()
    {
        $mailmanager = new MailManager();
        $mails = $mailmanager ->insertMail(['mail' => $mailmanager]);
        return $this->twig->render('Home/index.html.twig', ['mail' => $mails]);
    }

    public function newsletter()
    {
        if(isset($_POST['newsletterform'])){
            if(isset($_POST['newsletter'])){
                if(!empty($_POST['newsletter'])){
                    $newsletter = htmlspecialchars($_POST['newsletter']);
                    if(filter_var($newsletter, FILTER_VALIDATE_EMAIL)) {
                        $reqip = $bdd->prepare("SELECT * FROM newsletter WHERE ip = ?");
                        $reqip->execute(array($_SERVER['REMOTE_ADDR']));
                        $ipexist = $reqip->rowCount();
                        if($ipexist == 0) {
                            $reqmail = $bdd->prepare("SELECT * FROM newsletter WHERE email = ?");
                            $reqmail->execute(array($newsletter));
                            $mailexist = $reqmail->rowCount();
                            if($mailexist == 0){
                                $sql = $bdd->prepare('INSERT INTO newsletter(email,ip,dates) VALUES (?,?,NOW())');
                                $sql->execute(array($newsletter,$_SERVER['REMOTE_ADDR']));
                                header("Location: newsletter.php");
                            } else {
                                $erreur = "Vous êtes déjà inscrit à la Newsletter..";
                            }
                        } else {
                            $erreur = "Vous êtes déjà inscrit à la Newsletter..";
                        }
                    } else {
                        $erreur = "Vous devez indiquer une adresse e-mail..";
                    }
                } else {
                    $erreur = "Vous devez remplir tout les champs vides..";
                }
            }
        }
    }
}
