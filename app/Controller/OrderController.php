<?php

namespace Controller;

use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Request\OrderRequest;
use Service\AuthenticationService;
use Service\OrderService;

class OrderController
{
    private OrderService $orderService; // If one class use object of other class then this object necessary write down as property because this object may useful in other method.
    private AuthenticationService $authenticationService;

    public function __construct(OrderService $orderService, AuthenticationService $authenticationService)
    {
        $this->orderService = $orderService;
        $this->authenticationService = $authenticationService;
    }
    public function getOrderForm()
    {
        require_once '../View/order.phtml';
    }
    public function postOrder(OrderRequest $request): void
    {
        $errors = $request->validate();

        if (empty($errors)) {
            $user = $this->authenticationService->getCurrentUser();
            if (!empty($user)) {
                $userId = $user->getId();

                $requestData = $request->getBody();
                $name = $requestData['name'];
                $lastName = $requestData['last-name'];
                $numberOfPhone = $requestData['number'];
                $address = $requestData['address'];

//                $orderService = new OrderService; // OrderController = f(OrderService).
                $this->orderService->create($userId, $name, $lastName, $numberOfPhone, $address); // инъекция зависимостей (The static method good or bad???)

                header('location: /order-product');
            } else {
                header('location: /login');
            }
        }
        require_once '../View/order.phtml';
    }

    public function getOrderProduct()
    {
        $user = $this->authenticationService->getCurrentUser();
        if (!empty($user)) {
            $userId = $user->getId();
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