<?php

namespace App\Entity;

use DomainException;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Email
{
    #[ORM\Column(type: 'string')]
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

    public function isEqualTo(Email $email):bool
    {
        return $this->email == $email->getValue();
    }
}