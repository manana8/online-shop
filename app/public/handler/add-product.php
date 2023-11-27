<?php

//$requestMethod = $_SERVER['REQUEST_METHOD'];
//if ($requestMethod === 'POST') {
//    function validate(array $data) {
//
//        $errors = [];
//
//        if(!empty($data['product_id'])) {
//            $productId = $data['product_id'];
//        }  else {
//            $errors['product_id'] = "Введите product's id" . "<br>";
//        }
//
//        if(!empty($data['quantity'])) {
//            $quantity = $data['quantity'];
//        } else {
//            $errors['quantity'] = 'Введите количество';
//        }
//
//        return $errors;
//    }
//
//    $errors = validate($_POST);
//
//    if (empty($errors)) {
//        $productId = $_POST['product_id'];
//        $quantity = $_POST['quantity'];
//
//        $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
//
//        $stmt = $pdo->prepare("INSERT INTO cart_products (product_id, quantity) VALUES (:product_id, :quantity)");
//        $stmt->execute(['product_id' => $productId, 'quantity' => $quantity]);
//
//        $stmt = $pdo->prepare("SELECT * FROM cart_products");
//        $stmt->execute();
//
//        $data = $stmt->fetchAll();
//    }
//}

//session_start();
//
//$pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
//
//$stmt = $pdo->query("SELECT * FROM products");
//$products = $stmt->fetchAll();

$stmt = $pdo->prepare("INSERT INTO carts (name, user_id) VALUES (:nameProd, :userId)");
$stmt->execute(['nameProd' => $product['name'], 'userId' => $_SESSION['user_id']]);
$cart = $stmt->fetchAll();

require_once './html/main.phtml';