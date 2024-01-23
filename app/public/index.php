<?php

use Controller\CartController;
use Controller\MainController;
use Controller\OrderController;
use Controller\UserController;
use Request\AddProductRequest;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\RegistrateRequest;
use Service\Authentication\AuthenticationInterface;
use Service\Authentication\SessionAuthenticationService;
use Service\OrderService;

require_once '../Autoloader.php';

Autoloader::registrate(dirname(__DIR__));

//$container = new Container();
//$container->set(OrderController::class, function (Container $container) {
//    $orderService = new OrderService();
//    $authenticationService = $container->get(AuthenticationInterface::class);
//
//    return new OrderController($orderService, $authenticationService);
//});
//
//$container->set(CartController::class, function (Container $container) {
//    $authenticationService = $container->get(AuthenticationInterface::class);
//
//    return new CartController($authenticationService);
//});
//
//$container->set(MainController::class, function (Container $container) {
//    $authenticationService = $container->get(AuthenticationInterface::class);
//
//    return new MainController($authenticationService);
//});
//
//$container->set(UserController::class, function (Container $container) {
//    $authenticationService = $container->get(AuthenticationInterface::class);
//
//    return new UserController($authenticationService);
//});
//
//$container->set(AuthenticationInterface::class, function () {
//    return new SessionAuthenticationService(); // Here we can change on Cookie Authentication Service
//});

//$app = new APP();
//$app->setContainer($container);
//
//$app->get('/login', UserController::class, 'getLoginForm');
//$app->post('/login', UserController::class, 'postLogin', LoginRequest::class);
//
//$app->get('/registrate', UserController::class, 'getRegistrateForm');
//$app->post('/registrate', UserController::class, 'postRegistrate', RegistrateRequest::class);
//
//$app->get('/main-page', MainController::class, 'mainPage');
//$app->post('/main-page', CartController::class, 'addProduct', AddProductRequest::class);
//
//$app->get('/user-cart', CartController::class, 'getCart');
//
//$app->get('/order', OrderController::class, 'getOrderForm');
//$app->post('/order', OrderController::class, 'postOrder', OrderRequest::class);
//
//$app->get('/order-product', OrderController::class, 'getOrderProduct');
require_once '../Config/dependencies.php';
require_once '../Config/routes.php';

$container = depend(new Container());

$app = routes(new APP(), $container);

$app->run();
