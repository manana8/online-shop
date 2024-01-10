<?php

namespace Controller;

use Model\Cart;
use Model\CartProduct;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Request\OrderRequest;

class OrderController
{
    public function getOrderForm()
    {
        require_once '../View/order.phtml';
    }
    public function postOrder(OrderRequest $request): void
    {
        $errors = $request->validate();

        if (empty($errors)) {
            session_start();
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];

                $requestData = $request->getBody();
                $name = $requestData['name'];
                $lastName = $requestData['last-name'];
                $numberOfPhone = $requestData['number'];
                $address = $requestData['address'];

                Order::create($userId, $name, $lastName, $numberOfPhone, $address);

//                $cart = Cart::getOneByUserId($userId);
//                $cartId = $cart->getId();
                $cartProducts = CartProduct::getAllByUserId($userId); // ALl products in the user's cart
                $productIds = [];
                foreach ($cartProducts as $cartProduct) {
                    $productIds[] = $cartProduct->getProductId();
                }

                $products = Product::getAllByIds($productIds); // All about user's products exclude quantity
                foreach ($cartProducts as $cartProduct) {
                    if (isset($products[$cartProduct->getProductId()]))
                    {
                        $product = $products[$cartProduct->getProductId()];
                        $prices[$product->getId()] = $product->getPrice() * $cartProduct->getQuantity();
                    }
                }

                OrderProduct::create($product->getId());

                header('location: /main-page');
            }
        }
        require_once '../View/order.phtml';
    }
}