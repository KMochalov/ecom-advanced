<?php

namespace App\Auth\Entity\User;

use DateTimeImmutable;

class User
{
    public function __construct(
        private  Id $id,
        private Email $email,
        private DateTimeImmutable $createdAt,
        private string $passwordHash,
        private Token $token,
    )
    {
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }
}