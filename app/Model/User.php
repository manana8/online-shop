<?php

class User
{
    public function create(string $name, string $email, string $password)
    {
        $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");

        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    public function getAll()
    {
        $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");

        $stmt = $pdo->prepare("SELECT * FROM users");
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getOne(string $login)
    {
        $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email");
        $stmt->execute(['email' => $login]);

        return $stmt->fetch();
    }
}