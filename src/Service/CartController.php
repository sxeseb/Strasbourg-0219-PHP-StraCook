<?php


namespace App\Service;

class CartController
{
    public function addToCart()
    {
        $errors = [];
        $datas = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_POST['gridRadios']) || empty($_POST['gridRadios'])) {
                $errors['price'] = "Selectionnez une option de prix";
            } else {
                $price = $this->testInput($_POST['gridRadios']);
                $datas['price'] = $price;
            }

            if (!isset($_POST['menu_q']) || empty($_POST['menu_q'])) {
                $errors['quantity'] = "Selectionnez un nombre de couverts";
            } else {
                $quantity = $this->testInput($_POST['menu_q']);
                $datas['quantity'] = $quantity;
            }

            if (isset($_POST['menu_id']) && !empty($_POST['menu_id'])) {
                $menuId = $this->testInput($_POST['menu_id']);
                $datas['menuId'] = $menuId;
            }

            if (isset($_POST['menu_name']) && !empty($_POST['menu_name'])) {
                $menuName = $this->testInput($_POST['menu_name']);
                $datas['menuName'] = $menuName;
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
