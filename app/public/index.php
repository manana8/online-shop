<?php

use Controller\CartController;
use Controller\MainController;
use Controller\UserController;
use Request\LoginRequest;
use Request\ProductRequest;
use Request\RegistrateRequest;
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
        'GET' => [
            'class' => UserController::class,
            'method' => 'getLoginForm',
        ],
        'POST'=>[
            'class' => UserController::class,
            'method' => 'postLogin',
            'request' => LoginRequest::class,
        ]
    ],
    '/registrate' => [
        'GET' => [
            'class' => UserController::class,
            'method' => 'getRegistrateForm',
        ],
        'POST'=>[
            'class' => UserController::class,
            'method' => 'postRegistrate',
            'request' => RegistrateRequest::class,
        ]
    ],
    '/main-page' => [
        'GET' => [
            'class' => MainController::class,
            'method' => 'mainPage',
        ],
        'POST'=> [
            'class' => CartController::class,
            'method' => 'addProduct',
            'request' => ProductRequest::class,
        ]
    ],
//    '/add-product' => [
//        'POST'=> [
//            'class' => CartController::class,
//            'method' => 'addProduct',
//            'request' => ProductRequest::class,
//        ]
//    ],
    '/user-cart' => [
        'POST'=> [
            'class' => CartController::class,
            'method' => 'userCart',
            ]
    ],
];

$requestUri = $_SERVER['REQUEST_URI'];

if (isset($routes[$requestUri])) {
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $routeMethods = $routes[$requestUri]; //GET or POST
    if (isset($routeMethods[$requestMethod])) {
        $handler = $routeMethods[$requestMethod];
        $class = $handler['class'];
        $method = $handler['method'];

        $obj = new $class();
        if (empty($handler['request'])) {
            $request = new Request($requestMethod, $_POST);
        } else {
            $requestClass = $handler['request'];
            $request = new $requestClass($requestMethod, $_POST);
        }
        $obj->$method($request);

    } else {
        echo "The method $routeMethods for $requestUri is not supported!";
    }

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

