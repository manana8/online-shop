<?php
//print_r($_SERVER);
$requestMethod = $_SERVER['REQUEST_METHOD'];
if ($requestMethod === 'POST') {
    function validate(array $data) {

        $errors = [];

        if(isset($data['name'])) {
            $name = $data['name'];
            if (strlen($name) < 2) {
                $errors['name'] = 'Имя должно содержать более 2 символов';
            }
        }  else {
            $errors['name'] = 'Введите имя';
        }

        if(isset($data['email'])) {
            $email = $data['email'];
            if (strlen($email) < 4) {
                $errors['email'] = 'Электронная почта должна содержать более 4 символов';
            } elseif (!strpos($email, '@')) {
                $errors['email'] = 'Некорректная почта';
            }
        } else {
            $errors['email'] = 'Введите адрес электронной почты';
        }

        if(isset($data['psw'])) {
            $password = $data['psw'];
            if (strlen($password) < 6) {
                $errors['psw'] = 'Пароль должен содержать 6 символов';
            }
        } else {
            $errors['psw'] = 'Введите пароль';
        }


        if(isset($data['psw-repeat'])) {
            $passwordRep = $data['psw-repeat'];
            if ($password !== $passwordRep) {
                $errors['psw-repeat'] = 'Пароли не совпадают';
            }
        } else {
            $errors['psw-repeat'] = 'Введите пароль';
        }

        return $errors;
    }

    $errors = validate($_POST);

    if (empty($errors)) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['psw'];

        $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");

        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

        $stmt = $pdo->prepare("SELECT * FROM users");
        $stmt->execute();

        $data = $stmt->fetchAll();

        header('location: /login');;
    }
}

require_once './html/registrate.phtml';
