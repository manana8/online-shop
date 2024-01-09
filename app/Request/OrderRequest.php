<?php

namespace Request;

class OrderRequest extends Request
{
    public function validate(): array
    {
        $errors = [];

        if (empty($this->body['name'])) {
            $errors['name'] = 'Введите имя';
        }

        if (empty($this->body['last-name'])) {
            $errors['last-name'] = 'Введите фамилию';
        }

        if (empty($this->body['number'])) {
            $errors['number'] = 'Введите номер телефона';
        }

        if (empty($this->body['address'])) {
            $errors['address'] = 'Введите адрес доставки';
        }

        return $errors;
    }
}