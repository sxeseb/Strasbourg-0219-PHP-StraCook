<?php


namespace App\Service;

class ValidationService
{

    public function checkCoord()
    {
        $errors = [];
        $userDatas = [];


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_POST['user_lastname']) || empty($_POST['user_lastname'])) {
                $errors['lastname'] = 'Veuillez renseigner votre nom';
            } elseif (!preg_match("/^([a-zA-Z' éèêà]+)$/", $_POST['user_lastname'])) {
                $errors['lastname'] = 'Veuillez saisir un nom valide';
            } else {
                $userDatas['lastname'] = $this->testInput($_POST['user_lastname']);
            }

            if (!isset($_POST['user_firstname']) || empty($_POST['user_firstname'])) {
                $errors['firstname'] = 'Veuillez renseigner votre prénom';
            } elseif (!preg_match("/^([a-zA-Z' éèêà]+)$/", $_POST['user_firstname'])) {
                $errors['firstname'] = 'Veuillez saisir un prénom valide';
            } else {
                $userDatas['firstname'] = $this->testInput($_POST['user_firstname']);
            }

            if (!isset($_POST['user_mail']) || empty($_POST['user_mail'])) {
                $errors['email'] = 'Veuillez renseigner le champs email';
            } elseif (!preg_match(
                "/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/",
                $_POST['user_mail']
            )) {
                $errors['email'] = 'Veuillez saisir un email valide';
            } else {
                $userDatas['email'] = $this->testInput($_POST['user_mail']);
            }

            if (!isset($_POST['user_phone']) || empty($_POST['user_phone'])) {
                $errors['phone'] = 'Veuillez renseigner le champs numéro';
            } elseif (!preg_match("/^0[1367][0-9]{8}$/", $_POST['user_phone'])) {
                $errors['phone'] = 'Veuillez saisir un numéro valide';
            } else {
                $userDatas['phone'] = $this->testInput($_POST['user_phone']);
            }

            if (!isset($_POST['user_adress']) || empty($_POST['user_adress'])) {
                $errors['adress'] = 'Veuillez renseigner le champs adresse';
            } elseif (!preg_match("/^([a-zA-Z0-9' éèêà]+)$/", $_POST['user_adress'])) {
                $errors['adress'] = 'Veuillez saisir une adresse valide';
            } else {
                $userDatas['adress'] = $this->testInput($_POST['user_adress']);
            }

            if (!isset($_POST['user_zip']) || empty($_POST['user_zip'])) {
                $errors['zip'] = 'Veuillez renseigner le code postal';
            } elseif (!preg_match("/^^6[78][0-9]{3}$/", $_POST['user_zip'])) {
                $errors['zip'] = 'Veuillez saisir un code postal valide';
            } else {
                $userDatas['zip'] = $this->testInput($_POST['user_zip']);
            }

            if (!isset($_POST['user_city']) || empty($_POST['user_city'])) {
                $errors['city'] ='Veuillez renseigner la ville';
            } elseif (!preg_match("/^([a-zA-Z' éèêà]+)$/", $_POST['user_city'])) {
                $errors['city'] = 'Veuillez saisir une ville valide';
            } else {
                $userDatas['city'] = $this->testInput($_POST['user_city']);
            }
        }

        return array($errors, $userDatas);
    }

    public function checkCart()
    {
        $errors = [];
        $resaDatas = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_POST['selected_date']) || empty($_POST['selected_date'])) {
                $errors['date'] = 'Veuillez selectionner une date pour votre réservation';
            } else {
                if ($this->checkDate($_POST['selected_date'])) {
                 /*   $errors['date'] = 'Date indisponible';
                } else {*/
                    $resaDatas['date'] = $this->testInput($_POST['selected_date']);
                }
            }

            if (!isset($_POST['arrival_time']) || empty($_POST['arrival_time'])) {
                $errors['arrival'] = 'Veuillez selectionner une heure d\'arrivée';
            } else {
                if (!$_POST['arrival_time']) {
                    $errors['arrival'] = 'Erreur format de l\'heure d\'arrivée';
                } else {
                    $resaDatas['arrival'] = $this->testInput($_POST['arrival_time']);
                }
            }

            $resaDatas['comment'] = "";
            if (isset($_POST['comment']) && !empty($_POST['comment'])) {
                if (!preg_match('/^([a-zA-Z\' éëèêàù,.!?]+)$/', $_POST['comment'])) {
                    $errors['comment'] = "Caractères non valides utilisés";
                } else {
                    $resaDatas['comment'] = $this->testInput($_POST['comment']);
                }
            }
        }
        return array($errors, $resaDatas);
    }

    public function checkDate($selected)
    {
        return 1;
    }

    public function testInput($input)
    {
        $input = trim($input);
        $input = stripcslashes($input);
        $input = htmlspecialchars($input);

        return $input;
    }
}
