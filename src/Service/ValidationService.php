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
            } elseif (!preg_match("/^([a-zA-Z' éèêàù]+)$/", $_POST['user_lastname'])) {
                $errors['lastname'] = 'Veuillez saisir un nom valide';
            } else {
                $userDatas['lastname'] = $this->testInput($_POST['user_lastname']);
            }

            if (!isset($_POST['user_firstname']) || empty($_POST['user_firstname'])) {
                $errors['firstname'] = 'Veuillez renseigner votre prénom';
            } elseif (!preg_match("/^([a-zA-Z' éèêàù]+)$/", $_POST['user_firstname'])) {
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
            } elseif (!preg_match("/^([a-zA-Z0-9' ]+)$/", $_POST['user_adress'])) {
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
                $errors['city'] = 'Veuillez renseigner la ville';
            } elseif (!preg_match("/^([a-zA-Z0-9' ]+)$/", $_POST['user_city'])) {
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

    public function checkMenu()
    {
        $errors = [];
        $menuDatas = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_POST['menu_name']) || empty($_POST['menu_name'])) {
                $errors['menu_name'] = 'Veuillez renseigner le nom du menu';
            } elseif (!preg_match("/^([a-zA-Z' éëèêàù,.!?]+)$/", $_POST['menu_name'])) {
                $errors['menu_name'] = 'Veuillez saisir un nom de menu valide';
            } else {
                $menuDatas['menu_name'] = $this->testInput($_POST['menu_name']);
            }

            if (!isset($_POST['menu_starter']) || empty($_POST['menu_starter'])) {
                $errors['menu_starter'] = 'Veuillez renseigner votre entrée';
            } elseif (!preg_match("/^([a-zA-Z' éëèêàù,.!?]+)$/", $_POST['menu_starter'])) {
                $errors['menu_starter'] = 'Veuillez saisir une entrée valide';
            } else {
                $menuDatas['menu_starter'] = $this->testInput($_POST['menu_starter']);
            }

            if (!isset($_POST['menu_main_course']) || empty($_POST['menu_main_course'])) {
                $errors['menu_main_course'] = 'Veuillez renseigner votre plat';
            } elseif (!preg_match("/^([aa-zA-Z' éëèêàù,.!?]+)$/", $_POST['menu_main_course'])) {
                $errors['menu_main_course'] = 'Veuillez saisir un plat valide';
            } else {
                $menuDatas['menu_main_course'] = $this->testInput($_POST['menu_main_course']);
            }

            if (!isset($_POST['menu_dessert']) || empty($_POST['menu_dessert'])) {
                $errors['menu_dessert'] = 'Veuillez renseigner votre dessert';
            } elseif (!preg_match("/^([a-zA-Z' éëèêàù,.!?]+)$/", $_POST['menu_dessert'])) {
                $errors['menu_dessert'] = 'Veuillez saisir un dessert valide';
            } else {
                $menuDatas['menu_dessert'] = $this->testInput($_POST['menu_dessert']);
            }

            if (!isset($_POST['menu_description']) || empty($_POST['menu_description'])) {
                $errors['menu_description'] = 'Veuillez renseigner votre description';
            } elseif (!preg_match("/^([a-zA-Z' éëèêàù,.!?]+)$/", $_POST['menu_description'])) {
                $errors['menu_description'] = 'Veuillez saisir une description valide';
            } else {
                $menuDatas['menu_description'] = $this->testInput($_POST['menu_description']);
            }
        }
        return array($errors, $menuDatas);
    }
}
