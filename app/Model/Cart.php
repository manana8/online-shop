<?php

//namespace Model;

class Cart
{
    public function getOne(int $userId): array|false
    {
        $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");

        $stmt = $pdo->prepare("SELECT id FROM carts WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(int $userId): void
    {
        $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");

        $stmt = $pdo->prepare("INSERT INTO carts (name, user_id) VALUES (:name, :user_id)");
        $stmt->execute(['name' => 'cart_' . $userId, 'user_id' => $userId]);
    }
}