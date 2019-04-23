<?php


namespace App\Service;

class ValidationController
{

    public function checkResa()
    {
        $errors = [];
        $datas = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_POST['user_lastname']) || empty($_POST['user_lastname'])) {
                $errors['lastname'] = 'Veuillez renseigner votre nom';
            } elseif (!preg_match("/^([a-zA-Z' ]+)$/", $_POST['user_lastname'])) {
                $errors['lastname'] = 'Veuillez saisir un nom valide';
            } else {
                $datas['lastname'] = $this->testInput($_POST['user_lastname']);
            }

            if (!isset($_POST['user_firstname']) || empty($_POST['user_firstname'])) {
                $errors['firstname'] = 'Veuillez renseigner votre prénom';
            } elseif (!preg_match("/^([a-zA-Z' ]+)$/", $_POST['user_firstname'])) {
                $errors['firstname'] = 'Veuillez saisir un prénom valide';
            } else {
                $datas['firstname'] = $this->testInput($_POST['user_firstname']);
            }

            // pregmatch à changer !! //


            if (!isset($_POST['user_mail']) || empty($_POST['user_mail'])) {
                $errors['email'] = 'Veuillez renseigner le champs email';
            } elseif (!preg_match(
                "/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/",
                $_POST['user_mail']
            )) {
                $errors['email'] = 'Veuillez saisir un email valide';
            } else {
                $datas['email'] = $this->testInput($_POST['user_mail']);
            }

            if (!isset($_POST['user_phone']) || empty($_POST['user_phone'])) {
                $errors['phone'] = 'Veuillez renseigner le champs numéro';
            } elseif (!preg_match("/^0[1367][0-9]{8}$/", $_POST['user_phone'])) {
                $errors['phone'] = 'Veuillez saisir un numéro valide';
            } else {
                $datas['phone'] = $this->testInput($_POST['user_phone']);
            }

            if (!isset($_POST['user_adress']) || empty($_POST['user_adress'])) {
                $errors['adress'] = 'Veuillez renseigner le champs adresse';
            } elseif (!preg_match("/^([a-zA-Z' ]+)$/", $_POST['user_adress'])) {
                $errors['adress'] = 'Veuillez saisir une adresse valide';
            } else {
                $datas['adress'] = $this->testInput($_POST['user_adress']);
            }

            if (!isset($_POST['user_zip']) || empty($_POST['user_zip'])) {
                $errors['zip'] = 'Veuillez renseigner le code postal';
            } elseif (!preg_match("/^^6[78][0-9]{3}$/", $_POST['user_zip'])) {
                $errors['zip'] = 'Veuillez saisir un code postal valide';
            } else {
                $datas['zip'] = $this->testInput($_POST['user_zip']);
            }

            if (!isset($_POST['user_city']) || empty($_POST['user_city'])) {
                $errors['city'] ='Veuillez renseigner la ville';
            } elseif (!preg_match("/^([a-zA-Z' ]+)$/", $_POST['user_city'])) {
                $errors['city'] = 'Veuillez saisir une ville valide';
            } else {
                $datas['city'] = $this->testInput($_POST['user_city']);
            }
        }

        return array($errors, $datas);
    }

    public function testInput($input)
    {
        $input = trim($input);
        $input = stripcslashes($input);
        $input = htmlspecialchars($input);

        return $input;
    }
}
