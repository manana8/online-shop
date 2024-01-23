<?php

use Controller\CartController;
use Controller\MainController;
use Controller\OrderController;
use Controller\UserController;
use Request\AddProductRequest;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\RegistrateRequest;

function routes(APP $app, $container): APP
{

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

    return $app;
}
