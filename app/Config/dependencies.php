<?php

use Controller\CartController;
use Controller\MainController;
use Controller\OrderController;
use Controller\UserController;
use Service\Authentication\AuthenticationInterface;
use Service\Authentication\SessionAuthenticationService;
use Service\OrderService;

function depend(Container $container): Container
{
    $container->set(OrderController::class, function (Container $container) {
        $orderService = new OrderService();
        $authenticationService = $container->get(AuthenticationInterface::class);

        return new OrderController($orderService, $authenticationService);
    });

    $container->set(CartController::class, function (Container $container) {
        $authenticationService = $container->get(AuthenticationInterface::class);

        return new CartController($authenticationService);
    });

    $container->set(MainController::class, function (Container $container) {
        $authenticationService = $container->get(AuthenticationInterface::class);

        return new MainController($authenticationService);
    });

    $container->set(UserController::class, function (Container $container) {
        $authenticationService = $container->get(AuthenticationInterface::class);

        return new UserController($authenticationService);
    });

    $container->set(AuthenticationInterface::class, function () {
        return new SessionAuthenticationService(); // Here we can change on Cookie Authentication Service
    });

    return $container;
}
