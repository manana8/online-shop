<?php

//if (isset($_COOKIE['user_id'])) {
    //print_r($_COOKIE['user_id']);

session_start();
if (isset($_SESSION['user_id'])) {
    //print_r($_SESSION['user_id']);

    $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");

    $stmt = $pdo->query("SELECT * FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
//    print_r($products);
//    exit();
} else {
    header('location: /login');
}

require_once './html/main.phtml';

