<?php

require_once '../Model/pdo.php';
class User
{
    public function create(string $name, string $email, string $password)
    {
        $pdo = new ConnectionDB();
        $stmt = $pdo->getPDO()->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    public function getAll()
    {
        $pdo = new ConnectionDB();
        $stmt = $pdo->getPDO()->prepare("SELECT * FROM users");
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getOneByEmail(string $email)
    {
        $pdo = new ConnectionDB();
        $stmt = $pdo->getPDO()->prepare("SELECT * FROM users WHERE email=:email");
        $stmt->execute(['email' => $email]);

        return $stmt->fetch();
    }

}