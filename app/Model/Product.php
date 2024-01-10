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

    public static function getAllByIds(array $ids): array|null
    {
        $marks = substr(str_repeat('?, ', count($ids)), 0, -2);
        $stmt = self::getPDO()->prepare("SELECT * FROM products WHERE id IN ($marks)"); // need ? = quantity array's elements
        $stmt->execute($ids);

        $allProducts = $stmt->fetchAll();

        if (empty($allProducts)) {
            return null;
        }

        $arr = [];
        foreach ($allProducts as $product) {
            $arr[$product['id']] = new self($product['id'], $product['name'], $product['price'], $product['image_link']);
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