<?php

namespace Model;

class OrderProduct extends Model
{
    private int $id;
    private int $orderId;
    private int $productId;
    private int $quantity;
    private float $price;

    public function __construct(int $id, int $orderId, int $productId, int $quantity, float $price)
    {
        $this->id = $id;
        $this->orderId = $orderId;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    public static function create(int $orderId, array $products, array $price): void
    {
        $stmt = self::getPDO()->prepare("INSERT INTO order_products (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)");

        foreach ($cartProducts as $cartProduct) {
            $stmt->execute(['order_id' => $orderId, 'product_id' => $cartProduct->getProductId(), 'quantity' => $quantity, 'price' => $cartProduct->getPrice()]);
        }

    }

    public static function getAllByOrderId(int $orderId): array | null
    {
        $stmt = self::getPDO()->prepare("SELECT * FROM order_products WHERE order_id=:order_id");
        $stmt->execute(['order_id' => $orderId]);

        $datas = $stmt->fetchAll();

        if (empty($datas)) {
            return null;
        }

        $arr = [];
        foreach ($datas as $data) {
            $arr[$data['product_id']] = new self($data['id'], $data['cart_id'], $data['product_id'], $data['quantity'], $data['price']);
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

    public function getPrice(): int
    {
        return $this->price;
    }
}