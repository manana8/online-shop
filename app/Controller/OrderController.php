<?php

namespace Controller;

use Model\Cart;
use Model\CartProduct;
use Model\Order;
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

                $order = Order::getOneByUserId($userId);

                if (empty($order)) {
                    Order::create($userId, $name, $lastName, $numberOfPhone, $address);

                    $order = Order::getOneByUserId($userId);
                }

                $cart = Cart::getOneByUserId($userId);
                $cartId = $cart->getId();
                $cartProducts = CartProduct::getAllByCartId($cartId);

                $productIds = [];

                foreach ($cartProducts as $cartProduct) {
                    $productIds[] = $cartProduct->getProductId();
                }

                $products = Product::getAllByIds($productIds);

                header('location: /main-page');
            }
        }
        require_once '../View/order.phtml';
    }
}