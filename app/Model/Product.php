<?php

namespace Model;

class Product extends Model
{
    private int $id;
    private string $name;
    private float $price;
    private string $imageLink;

    public function __construct(int $id, string $name, float $price, string $imageLink)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->imageLink= $imageLink;
    }

    public static function getAll(): null|array
    {
        $stmt = self::getPDO()->query("SELECT * FROM products");
        $allProducts = $stmt->fetchAll();

        if (empty($allProducts)) {
            return null;
        }

        $arr = [];
        foreach ($allProducts as $product) {
            $arr[] = new self($product['id'], $product['name'], $product['price'], $product['image_link']);
        }
        return $arr;
    }

    public static function getAllById(int $id): array|null
    {
        $stmt = self::getPDO()->prepare("SELECT * FROM products WHERE id=:id");
        $stmt->execute(['id' => $id]);

        $allProducts = $stmt->fetchAll();

        if (empty($allProducts)) {
            return null;
        }

        $arr = [];
        foreach ($allProducts as $product) {
            $arr[] = new self($product['id'], $product['name'], $product['price'], $product['image_link']);
        }
        return $arr;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getImageLink(): string
    {
        return $this->imageLink;
    }
}