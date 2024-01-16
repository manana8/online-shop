<?php

namespace Controller;

use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Request\OrderRequest;
use Service\OrderService;

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

                OrderService::create($userId, $name, $lastName, $numberOfPhone, $address); // The static method good or bad???

                header('location: /order-product');
            } else {
                header('location: /login');
            }
        }
        require_once '../View/order.phtml';
    }

    public function getOrderProduct()
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $order = Order::getOneByUserId($userId);
            $orderId = $order->getId();
            $orderProducts = OrderProduct::getAllByOrderId($orderId);
//            $orderProducts = OrderProduct::getAllByUserId($userId);

            foreach ($orderProducts as $orderProduct) {
                $productIds[] = $orderProduct->getProductId();
            }

            $products = Product::getAllByIds($productIds);

            require_once '../View/order-product.phtml';
        } else {
            header('location: /login');
        }
    }
}