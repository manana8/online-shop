<?php

namespace Controller;

use Model\User;
use Request\LoginRequest;
use Request\RegistrateRequest;
use Service\Authentication\AuthenticationInterface;

class UserController
{
    private readonly AuthenticationInterface $authenticationService;

    public function __construct(AuthenticationInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

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
        require_once '../View/login.phtml';
    }


    public function postLogin(LoginRequest $request): void
    {
        $errors = $request->validate();

        if (empty($errors)) {
            $requestData = $request->getBody();
            $login = $requestData['login'];
            $password = $requestData['password'];

            $result = $this->authenticationService->login($login, $password);

            if ($result) {
                header('location: /main-page');
            }

            $errors['login'] = 'Неправильный логин или пароль';

        }
        require_once '../View/login.phtml';
    }
}