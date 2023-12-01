<?php

//namespace Controller;

class CartController
{
    public function addProduct(): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if ($requestMethod === 'POST') {
            $errors = $this->validateProduct($_POST);

            if (empty($errors)) {
                session_start();
                if (isset($_SESSION['user_id'])) {
                    $userId = $_SESSION['user_id'];
                    $productId = $_POST['product_id'];
                    $quantity = $_POST['quantity'];

                    //$pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
                    require_once '../Model/Cart.php';
                    $cartModel = new Cart();
                    $cart = $cartModel->getOne($userId);

                    if (empty($cart)) {
                        $cartModel->create($userId);

                        $cart = $cartModel->getOne($userId);
                    }

                    require_once '../Model/CartProduct.php';
                    $cartProductModel = new CartProduct();
                    $cartProductModel->create($cart, $productId, $quantity);

                    header('location: /main-page');
                }
            }
        }
    }

    private function validateProduct(array $data): array
    {

        $errors = [];

        if (empty($data['product_id'])) {
            $errors['product_id'] = "Введите product's id" . "<br>";
        }

        if (empty($data['quantity'])) {
            $errors['quantity'] = 'Введите количество';
        }

        return $errors;
    }
}