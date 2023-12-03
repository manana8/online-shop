<?php

require_once '../Model/pdo.php';
class Main
{
    public function getAll(): bool|array
    {
        $pdo = new ConnectionDB();
        $stmt = $pdo->getPDO()->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}