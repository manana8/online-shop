<?php

use Controller\CartController;
use Controller\MainController;
use Controller\OrderController;
use Controller\UserController;
use Request\AddProductRequest;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\RegistrateRequest;

require_once '../Autoloader.php';

Autoloader::registrate(dirname(__DIR__));

$container = new Container();
$container->set(OrderController::class, function () {
    $orderService = new \Service\OrderService();
    $authenticationService = new \Service\AuthenticationService();

    return new OrderController($orderService, $authenticationService);
});

$container->set(CartController::class, function () {
    $authenticationService = new \Service\AuthenticationService();

    return new CartController($authenticationService);
});

$container->set(MainController::class, function () {
    $authenticationService = new \Service\AuthenticationService();

    return new MainController($authenticationService);
});

$app = new APP();
$app->setContainer($container);

$app->get('/login', UserController::class, 'getLoginForm');
$app->post('/login', UserController::class, 'postLogin', LoginRequest::class);

$app->get('/registrate', UserController::class, 'getRegistrateForm');
$app->post('/registrate', UserController::class, 'postRegistrate', RegistrateRequest::class);

$app->get('/main-page', MainController::class, 'mainPage');
$app->post('/main-page', CartController::class, 'addProduct', AddProductRequest::class);

$app->get('/user-cart', CartController::class, 'getCart');

$app->get('/order', OrderController::class, 'getOrderForm');
$app->post('/order', OrderController::class, 'postOrder', OrderRequest::class);

$app->get('/order-product', OrderController::class, 'getOrderProduct');

$app->run();
