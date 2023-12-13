<?php

namespace Model;

class Order extends Model
{
    private int $id;
    private string $name;
    private string $lastName;
    private string $numberOfPhone;
    private string $address;

    public function __construct(int $id, string $name, string $lastName,string $numberOfPhone, string $address)
    {
        $this->id = $id;
        $this->name = $name;
        $this->lastName = $lastName;
        $this->numberOfPhone = $numberOfPhone;
        $this->address = $address;
    }

    public static function create(string $name, string $lastName,string $numberOfPhone, string $address): void
    {
        $stmt = self::getPDO()->prepare("INSERT INTO orders (name, last_name, number_of_phone, address) VALUES (:name, :last_name, :number_of_phone, :address)");
        $stmt->execute(['name' => $name, 'last_name' => $lastName, 'number_of_phone' => $numberOfPhone, 'address' => $address]);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getNumberOfPhone(): string
    {
        return $this->numberOfPhone;
    }

    public function getAddress(): string
    {
        return $this->address;
    }
}