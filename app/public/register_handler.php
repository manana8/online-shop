<?php

//print_r($_POST);

$pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");

$name = $_POST['name'];
    if (strlen($name) < 2)
    {
        echo 'Имя должно содержать более 2 символов';
        return;
    }

$email = $_POST['email'];
    if (strlen($email) < 4)
    {
        echo 'Электронная почта должна содержать более 4 символов';
        return;
    }

    if (!strpos($email, '@'))
    {
        echo 'Некорректная почта';
        return;
    }

$password = $_POST['psw'];
    if (strlen($password) < 6)
    {
        echo 'Пароль должен содержать 6 символов';
        return;
    }

$passwordRep = $_POST['psw-repeat'];

    if ($password !== $passwordRep)
    {
        echo 'Пароли не совпадают';
        return;
    }

//$pdo->exec("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");

$stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
$stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

$stmt = $pdo->prepare("SELECT * FROM users");
$stmt->execute();

$data = $stmt->fetchAll();

print_r($data);