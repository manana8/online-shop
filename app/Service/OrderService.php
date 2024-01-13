<?php

namespace Service;

use Model\Cart;
use Model\CartProduct;
use Model\Model;
use Model\Order;
use Model\OrderProduct;
use Model\Product;

class OrderService
{
    public static function create(int $userId, string $name, string $lastName, string $numberOfPhone, string $address): void
    {
        $cart = Cart::getOneByUserId($userId);
        $cartId = $cart->getId();
//      $cartProducts = CartProduct::getAllByUserId($userId); // The application 'INNER JOIN'
        $cartProducts = CartProduct::getAllByCartId($cartId); // ALl products in the user's cart
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
        // The realization THE TRANSACTION
        $pdo = Model::getPDO();
        $pdo->beginTransaction();

        try {
            Order::create($userId, $name, $lastName, $numberOfPhone, $address);
            $orderId = Order::getOneByUserId($userId)->getId();

            OrderProduct::create($orderId, $cartProducts, $prices);
            CartProduct::clear($cartId);
        } catch (\Throwable $throwable) {
            echo $throwable->getMessage();
            $pdo->rollBack(); // Finish the transaction with exceptions that is errors
        }

        $pdo->commit(); // Finish the transaction wo errors
    }
}