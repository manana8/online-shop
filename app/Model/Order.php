<?php

namespace Model;

class Order extends Model
{
    private int $id;
    private int $userId;
    private string $name;
    private string $lastName;
    private string $numberOfPhone;
    private string $address;

    public function __construct(int $id, int $userId, string $name, string $lastName, string $numberOfPhone, string $address)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->name = $name;
        $this->lastName = $lastName;
        $this->numberOfPhone = $numberOfPhone;
        $this->address = $address;
    }

    public static function create(int $userId, string $name, string $lastName,string $numberOfPhone, string $address): void
    {
        $stmt = self::getPDO()->prepare("INSERT INTO orders (user_id, name, last_name, number_of_phone, address) VALUES (:user_id, :name, :last_name, :number_of_phone, :address)");
        $stmt->execute(['user_id' => $userId, 'name' => $name, 'last_name' => $lastName, 'number_of_phone' => $numberOfPhone, 'address' => $address]);
    }

    public static function getOneByUserId(int $userId): Order | null
    {
        $stmt = self::getPDO()->prepare("SELECT * FROM orders WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);

        $data = $stmt->fetch();

        if (empty($data)) {
            return null;
        }

        return new self($data['id'], $data['user_id'], $data['name'], $data['last_name'], $data['number_of_phone'], $data['address']);
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

    public function getUserId(): int
    {
        return $this->userId;
    }
}