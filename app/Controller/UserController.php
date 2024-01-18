<?php

namespace Controller;

use Model\User;
use Request\LoginRequest;
use Request\RegistrateRequest;

class UserController
{
    public function getRegistrateForm()
    {
        require_once '../View/registrate.phtml';
    }
    public function postRegistrate(RegistrateRequest $request)
    {
        $errors = $request->validate();

        if (empty($errors)) {
            $requestData = $request->getBody();
            $name = $requestData['name'];
            $email = $requestData['email'];
            $password = $requestData['psw'];
            $hash = password_hash($password, PASSWORD_DEFAULT);//Hash of password

            //require_once '../Model/User.php';
//                $registrationModel = new User();
            User::create($name, $email, $hash);

//                $data = User::getAll();

            header('location: /login');
        }
        require_once '../View/registrate.phtml';
    }

    public function getLoginForm()
    {
//        $a =5;
//        $b =0;
//        echo $a / $b;
        require_once '../View/login.phtml';
    }


    public function postLogin(LoginRequest $request): void
    {
        $errors = $request->validate();

        if (empty($errors)) {
            $requestData = $request->getBody();
            $login = $requestData['login'];
            $password = $requestData['password'];

//                require_once '../Model/User.php';
//                $loginModel = new User();
//                $data = $loginModel->getOneByEmail($login);
            $data = User::getOneByEmail($login);
//                print_r($data); die();

            if (empty($data)) {
                $errors['login'] = 'Неправильный логин или пароль';
            } else {
                if (password_verify($password, $data->getPassword())) {
                    //setcookie('user_id', $data['id']);
                    session_start();
                    $_SESSION['user_id'] = $data->getId();
                    header('location: /main-page');
                } else {
                    $errors['password'] = 'Неправильный логин или пароль';
                }
            }

        }
        require_once '../View/login.phtml';
    }
}