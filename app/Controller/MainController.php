<?php

namespace Controller;

use Model\Product;
use Service\Authentication\AuthenticationInterface;

class MainController
{
    private AuthenticationInterface $authenticationService;

    public function __construct(AuthenticationInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }
    public function mainPage(): void
    {
        $user = $this->authenticationService->getCurrentUser();
        if (empty($user)) {
            header('location: /login');
        }
//      require_once '../Model/Product.php';
//      $mainModel = new Product();
        $products = Product::getAll();

        require_once '../View/main.phtml';
    }
}