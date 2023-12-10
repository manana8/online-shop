<?php

namespace Request;

class LoginRequest extends Request
{
    public function validate(): array
    {
        $errors = [];

        if (isset($this->body['login'])) {
            $login = $this->body['login'];
            if (strlen($login) < 4) {
                $errors['login'] = 'логин должен содержать более 4 символов';
            }
        } else {
            $errors['login'] = 'Введите логин';
        }

        if (isset($this->body['password'])) {
            $password = $this->body['password'];
        } else {
            $errors['password'] = 'Введите пароль';
        }

        return $errors;
    }
}