<?php

namespace Controller;

use Model\Product;
use Service\AuthenticationService;

class MainController
{
    private AuthenticationService $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }
    public function mainPage(): void
    {
        $user = $this->authenticationService->getCurrentUser();
        if (!empty($user)) {
//            require_once '../Model/Product.php';
//            $mainModel = new Product();
            $products = Product::getAll();
        } else {
            header('location: /login');
        }

        require_once '../View/main.phtml';
    }
}