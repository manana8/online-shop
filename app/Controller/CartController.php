<?php

namespace Controller;

use Couchbase\View;
use Model\Cart;
use Model\CartProduct;
use Request\Request;

//import class

class CartController
{
    public function addProduct(Request $request): void
    {
        $requestData = $request->getBody();
        $requestMethod = $request->getMethod();
        if ($requestMethod === 'POST') {
            $errors = $this->validateProduct($requestData);

            if (empty($errors)) {
                session_start();
                if (isset($_SESSION['user_id'])) {
                    $userId = $_SESSION['user_id'];
                    $productId = $requestData['product_id'];
                    $quantity = $requestData['quantity'];

                    //$pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
//                    require_once '../Model/Cart.php';
//                    $cartModel = new Cart();
                    $cart = Cart::getOneByUserId($userId);

                    if (empty($cart)) {
                        Cart::create($userId);

                        $cart = Cart::getOneByUserId($userId);
                    }

//                    require_once '../Model/CartProduct.php';
//                    $cartProductModel = new CartProduct();
//                    $cartProductModel->create($cart, $productId, $quantity);
                    CartProduct::create($cart->getId(), $productId, $quantity);

                    header('location: /main-page');
                }
            }
        }
    }

    private function validateProduct(array $data): array
    {

        $errors = [];

        if (empty($data['product_id'])) {
            $errors['product_id'] = "Введите product's id" . "<br>";
        }

        if (empty($data['quantity'])) {
            $errors['quantity'] = 'Введите количество';
        }

        return $errors;
    }

    public function test() {
        session_start();
        $userId = $_SESSION['user_id'];
        $cart = Cart::getOneByUserId($userId);
        $cartId = $cart->getId();
        $test = CartProduct::getAllByCartId($cartId);
//        foreach ($test as $test1) {
//            $test2 = $test1->getProductId();
//            echo $test2;
//        }
//         die();
        require_once '../View/cart.phtml';
    }
}