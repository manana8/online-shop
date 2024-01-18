<?php

namespace Controller;

use Couchbase\View;
use Model\Cart;
use Model\CartProduct;
use Model\Product;
use Request\AddProductRequest;
use Request\Request;
use Service\AuthenticationService;

//import class

class CartController
{
    private AuthenticationService $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function addProduct(AddProductRequest $request): void
    {
        $errors = $request->validate();

        if (empty($errors)) {
            $user = $this->authenticationService->getCurrentUser();
            if (!empty($user)) {
                $requestData = $request->getBody();
                $userId = $user->getId();
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
            } else {
                header('location: /login');
            }
        }
    }

    public function getCart(): void
    {
        $user = $this->authenticationService->getCurrentUser();
//        session_start();
        //check users
        if (!empty($user)) {
//            $userId = $_SESSION['user_id'];
            $cart = Cart::getOneByUserId($user->getId());
            if (isset($cart)) {
                $cartId = $cart->getId();
                $cartProducts = CartProduct::getAllByCartId($cartId);
                if (isset($cartProducts)) {
                    $productIds = [];

                    foreach ($cartProducts as $cartProduct) {
                        $productIds[] = $cartProduct->getProductId();
                    }

                    $products = Product::getAllByIds($productIds);

                    require_once '../View/cart.phtml';
                } else {
                    echo 'The cart is empty :(';
                }

            } else {
                echo 'The cart not founded :(';
            }

        } else {
            header('location: /login');
        }
    }
}