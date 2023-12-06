<?php

use Controller\CartController;
use Controller\MainController;
use Controller\UserController;
use Request\Request;

$autoload = function (string $className) {
    $path = str_replace('\\', '/', $className);
    $path = dirname(__DIR__) . "/" . $path . ".php";
//    print_r($path); die();
//    $path = "../Controller/$className.php";
    if (file_exists($path)) {
        require_once $path;
    }
};

spl_autoload_register($autoload);

$routes = [
    '/login' => [
        'class' => UserController::class,
        'method' => 'login',
    ],
    '/registrate' => [
        'class' => UserController::class,
        'method' => 'registrate',
    ],
    '/main-page' => [
        'class' => MainController::class,
        'method' => 'mainPage',
    ],
    '/add-product' => [
        'class' => CartController::class,
        'method' => 'addProduct',
    ],
];

$requestUri = $_SERVER['REQUEST_URI'];

if (isset($routes[$requestUri])) {
    $handler = $routes[$requestUri];
    $class = $handler['class'];
    $method = $handler['method'];

    $obj = new $class();
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $request = new Request($requestMethod);
    $request->setBody($_POST);

    $obj->$method($request);
} else {
    require_once '../View/error404.html';
}

//if ($requestUri === '/login') {
//    $userController = new UserController();
//    $userController->login($_POST);
//} elseif ($requestUri === '/registrate') {
//    $userController = new UserController();
//    $userController->registrate($_POST);
//} elseif ($requestUri === '/main-page') {
//    $mainController = new MainController();
//    $mainController->mainPage();
//} elseif ($requestUri === '/add-product') {
//    $cartController = new CartController();
//    $cartController->addProduct($_POST);

