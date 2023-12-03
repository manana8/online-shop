<?php

//namespace Controller;

class UserController
{
    public function registrate(array $requestData) {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if ($requestMethod === 'POST') {

            $errors = $this->validateRegistrate($requestData);

            if (empty($errors)) {
                $name = $requestData['name'];
                $email = $requestData['email'];
                $password = $requestData['psw'];

                require_once '../Model/User.php';
                $registrationModel = new User();
                $registrationModel->create($name, $email, $password);

                $data = $registrationModel->getAll();

                header('location: /login');;
            }
        }
        require_once '../View/registrate.phtml';
    }
    private function validateRegistrate(array $data): array
    {
        $errors = [];

        if (isset($data['name'])) {
            $name = $data['name'];
            if (strlen($name) < 2) {
                $errors['name'] = 'Имя должно содержать более 2 символов';
            }
        } else {
            $errors['name'] = 'Введите имя';
        }

        if (isset($data['email'])) {
            $email = $data['email'];
            if (strlen($email) < 4) {
                $errors['email'] = 'Электронная почта должна содержать более 4 символов';
            } elseif (!strpos($email, '@')) {
                $errors['email'] = 'Некорректная почта';
            }
        } else {
            $errors['email'] = 'Введите адрес электронной почты';
        }

        if (isset($data['psw'])) {
            $password = $data['psw'];
            if (strlen($password) < 6) {
                $errors['psw'] = 'Пароль должен содержать 6 символов';
            }
        } else {
            $errors['psw'] = 'Введите пароль';
        }


        if (isset($data['psw-repeat'])) {
            $passwordRep = $data['psw-repeat'];
            if ($password !== $passwordRep) {
                $errors['psw-repeat'] = 'Пароли не совпадают';
            }
        } else {
            $errors['psw-repeat'] = 'Введите пароль';
        }

        return $errors;
    }

    public function login(array $requestData)
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if ($requestMethod === 'POST') {
            $errors = $this->validateLogin($requestData);

            if (empty($errors)) {
                $login = $requestData['login'];
                $password = $requestData['password'];

                require_once '../Model/User.php';
                $loginModel = new User();
                $data = $loginModel->getOneByEmail($login);

                if (empty($data)) {
                    $errors['login'] = 'Неправильный логин или пароль';
                } else {
                    if ($password === $data['password']) {
                        //setcookie('user_id', $data['id']);
                        session_start();
                        $_SESSION['user_id'] = $data['id'];
                        header('location: /main-page');
                    } else {
                        $errors['password'] = 'Неправильный логин или пароль';
                    }
                }
            }
        }
        require_once '../View/login.phtml';
    }

    private function validateLogin(array $data)
    {
        $errors = [];

        if (isset($data['login'])) {
            $login = $data['login'];
            if (strlen($login) < 4) {
                $errors['login'] = 'логин должен содержать более 4 символов';
            }
        } else {
            $errors['login'] = 'Введите логин';
        }

        if (isset($data['password'])) {
            $password = $data['password'];
        } else {
            $errors['password'] = 'Введите пароль';
        }

        return $errors;
    }
}