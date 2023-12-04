<?php

class CartProduct extends Model
{
    public function create(array $cart, int $productId, int $quantity)
    {
        $stmt = $this->pdo->prepare("INSERT INTO cart_products (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)");
        $stmt->execute(['cart_id' => $cart['id'], 'product_id' => $productId, 'quantity' => $quantity]);
    }
}