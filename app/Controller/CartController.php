<?php

namespace Controller;

use Couchbase\View;
use Model\Cart;
use Model\CartProduct;
use Model\Product;
use Request\ProductRequest;
use Request\Request;

//import class

class CartController
{
    public function addProduct(ProductRequest $request): void
    {
        $errors = $request->validate();

        if (empty($errors)) {
            session_start();
            if (isset($_SESSION['user_id'])) {
                $requestData = $request->getBody();
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

    public function userCart() {
        session_start();
        $userId = $_SESSION['user_id'];
        $cart = Cart::getOneByUserId($userId);
        $cartId = $cart->getId();
        $cartProducts = CartProduct::getAllByCartId($cartId);
        $productIds = [];

        foreach ($cartProducts as $cartProduct) {
            $productIds[] = $cartProduct->getProductId();
        }

        $products = Product::getAllById((int)$productIds);
//        print_r($products); die();


        require_once '../View/cart.phtml';
    }
}