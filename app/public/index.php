<?php

$requestUri = $_SERVER['REQUEST_URI'];

if ($requestUri === '/login') {
    require_once '../Controller/UserController.php';
    $userController = new UserController();
    $userController->login($_POST);
} elseif ($requestUri === '/registrate') {
    require_once '../Controller/UserController.php';
    $userController = new UserController();
    $userController->registrate($_POST);
} elseif ($requestUri === '/main-page') {
    require_once '../Controller/MainController.php';
    $mainController = new MainController();
    $mainController->mainPage();
} elseif ($requestUri === '/add-product') {
    require_once '../Controller/CartController.php';
    $cartController = new CartController();
    $cartController->addProduct($_POST);
} else {
    require_once '../View/error404.html';
}
