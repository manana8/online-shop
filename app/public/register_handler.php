<?php

//print_r($_POST);

$pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['psw'];
$passwordRep = $_POST['psw-repeat'];

//$pdo->exec("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");

$stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
$stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

