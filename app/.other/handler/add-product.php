<?php

$requestMethod = $_SERVER['REQUEST_METHOD'];
if ($requestMethod === 'POST') {
    function validate(array $data)
    {

        $errors = [];

        if(empty($data['product_id']))
        {
            $errors['product_id'] = "Введите product's id" . "<br>";
        }

        if(empty($data['quantity']))
        {
            $errors['quantity'] = 'Введите количество';
        }

        return $errors;
    }

    $errors = validate($_POST);

    if (empty($errors))
    {
        session_start();
        if (isset($_SESSION['user_id']))
        {
            $userId = $_SESSION['user_id'];
            $productId = $_POST['product_id'];
            $quantity = $_POST['quantity'];

            $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");

            $stmt = $pdo->prepare("SELECT id FROM carts WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $userId]);
            $cart = $stmt->fetch(PDO::FETCH_ASSOC);
            //print_r($cart); exit();

            if (empty($cart))
            {
                $stmt = $pdo->prepare("INSERT INTO carts (name, user_id) VALUES (:name, :user_id)");
                $stmt->execute(['name' => 'cart_' . $userId, 'user_id' => $userId]);
                //print_r($_SESSION['user_id']);

                $stmt = $pdo->prepare("SELECT * FROM carts WHERE user_id = :user_id");
                $stmt->execute(['user_id' => $userId]);
                $cart = $stmt->fetch(PDO::FETCH_ASSOC);
                //print_r($cart);
            }

            $stmt = $pdo->prepare("INSERT INTO cart_products (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)");
            $stmt->execute(['cart_id' => $cart['id'],'product_id' => $productId, 'quantity' => $quantity]);

            header('location: /main-page');
        }

    }
}


//require_once './html/main.phtml';