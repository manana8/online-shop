<?php

namespace Controller;

use Model\Product;

class MainController
{
    public function mainPage(): void
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
//            require_once '../Model/Product.php';
//            $mainModel = new Product();
            $products = Product::getAll();
        } else {
            header('location: /login');
        }

        require_once '../View/main.phtml';
    }
}