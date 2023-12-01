<?php

$requestUri = $_SERVER['REQUEST_URI'];

if ($requestUri === '/login') {
    require_once '../Controller/UserController.php';
    $userController = new UserController();
    $userController->login();
} elseif ($requestUri === '/registrate') {
    require_once '../Controller/UserController.php';
    $userController = new UserController();
    $userController->registrate();
} elseif ($requestUri === '/main-page') {
    require_once '../Controller/MainController.php';
    $userController = new MainController();
    $userController->mainPage();
} elseif ($requestUri === '/add-product') {
    require_once '../Controller/CartController.php';
    $userController = new CartController();
    $userController->addProduct();
} else {
    echo 'The page is not founded';
}
