<?php

require_once '../Model/pdo.php';
class CartProduct
{
    public function create(array $cart, int $productId, int $quantity)
    {
        $pdo = new ConnectionDB();
        $stmt = $pdo->getPDO()->prepare("INSERT INTO cart_products (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)");
        $stmt->execute(['cart_id' => $cart['id'], 'product_id' => $productId, 'quantity' => $quantity]);
    }
}