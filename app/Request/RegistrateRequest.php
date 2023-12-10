<?php

namespace Request;

class RegistrateRequest extends Request
{
    public function validate(): array
    {
        $errors = [];

        if (isset($this->body['name'])) {
            $name = $this->body['name'];
            if (strlen($name) < 2) {
                $errors['name'] = 'Имя должно содержать более 2 символов';
            }
        } else {
            $errors['name'] = 'Введите имя';
        }

        if (isset($this->body['email'])) {
            $email = $this->body['email'];
            if (strlen($email) < 4) {
                $errors['email'] = 'Электронная почта должна содержать более 4 символов';
            } elseif (!strpos($email, '@')) {
                $errors['email'] = 'Некорректная почта';
            }
        } else {
            $errors['email'] = 'Введите адрес электронной почты';
        }

        if (isset($this->body['psw'])) {
            $password = $this->body['psw'];
            if (strlen($password) < 6) {
                $errors['psw'] = 'Пароль должен содержать 6 символов';
            }
        } else {
            $errors['psw'] = 'Введите пароль';
        }

        if (isset($this->body['psw-repeat'])) {
            $passwordRep = $this->body['psw-repeat'];
            if ($password !== $passwordRep) {
                $errors['psw-repeat'] = 'Пароли не совпадают';
            }
        } else {
            $errors['psw-repeat'] = 'Введите пароль';
        }

        return $errors;
    }
}