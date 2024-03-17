<?php

namespace App\Auth\Entity\User;

use DomainException;

class Email
{
    private string $email;
    public function __construct(string $email)
    {
        if (!$email) {
            throw new DomainException('Email не должен быть пустым');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new DomainException('Некорректный Email');
        };

        $this->email = mb_strtolower($email);
    }

    public function getValue():string
    {
        return $this->email;
    }
}