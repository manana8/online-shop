<?php

namespace Request;

class ProductRequest extends Request
{
    public function validate(): array
    {
        $errors = [];

        if (empty($this->body['product_id'])) {
            $errors['product_id'] = "Введите product's id" . "<br>";
        }

        if (empty($this->body['quantity'])) {
            $errors['quantity'] = 'Введите количество';
        }

        return $errors;
    }
}