<?php

//namespace Controller;

class MainController
{
    public function mainPage(): void
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
//            require_once '../Model/Product.php';
            $mainModel = new Product();
            $products = $mainModel->getAll();
        } else {
            header('location: /login');
        }

        require_once '../View/main.phtml';
    }
}