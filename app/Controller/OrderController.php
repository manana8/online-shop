<?php

namespace Controller;

use Model\Order;
use Request\RegistrateRequest;

class OrderController
{
    public function getOrderForm()
    {
        require_once '../View/order.phtml';
    }
    public function postOrder(RegistrateRequest $request)
    {
        $errors = $request->validate();

        if (empty($errors)) {
            $requestData = $request->getBody();
            $name = $requestData['name'];
            $lastName = $requestData['last-name'];
            $numberOfPhone = $requestData['number'];
            $address = $requestData['address'];

            //require_once '../Model/User.php';
//                $registrationModel = new User();
            Order::create($name, $lastName, $numberOfPhone, $address);

//                $data = User::getAll();

            header('location: /main-page');
        }
        require_once '../View/order.phtml';
    }
}