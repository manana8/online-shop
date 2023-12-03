<?php

//namespace Model;
require_once '../Model/pdo.php';
class Cart
{
    public function getOneByUserId(int $userId): array|false
    {
        $pdo = new ConnectionDB();
        $stmt = $pdo->getPDO()->prepare("SELECT id FROM carts WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(int $userId, string $name = null): void
    {
        if ($name === null) {
            $name = "cart_$userId";
        }
        $pdo = new ConnectionDB();
        $stmt = $pdo->getPDO()->prepare("INSERT INTO carts (name, user_id) VALUES (:name, :user_id)");
        $stmt->execute(['name' => $name, 'user_id' => $userId]);
    }
}