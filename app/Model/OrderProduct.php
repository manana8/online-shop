<?php

namespace Model;

class OrderProduct extends Model
{
    private int $id;
    private int $orderId;
    private int $productId;
    private int $quantity;

    public function __construct(int $id, int $orderId, int $productId, int $quantity)
    {
        $this->id = $id;
        $this->orderId = $orderId;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    public static function create(int $orderId, int $productId, int $quantity): void
    {
        $stmt = self::getPDO()->prepare("INSERT INTO order_products (order_id, product_id, quantity) VALUES (:order_id, :product_id, :quantity)");
        $stmt->execute(['order_id' => $orderId, 'product_id' => $productId, 'quantity' => $quantity]);
    }

    public static function getAllByOrderId(int $orderId): ?array
    {
        $stmt = self::getPDO()->prepare("SELECT * FROM order_products WHERE cart_id=:cart_id");
        $stmt->execute(['order_id' => $orderId]);

        $datas = $stmt->fetchAll();

        if (empty($datas)) {
            return null;
        }

        $arr = [];
        foreach ($datas as $data) {
            $arr[$data['product_id']] = new self($data['id'], $data['cart_id'], $data['product_id'], $data['quantity']);
        }
        return $arr;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}