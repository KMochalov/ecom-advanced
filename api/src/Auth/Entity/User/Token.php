<?php

namespace App\Auth\Entity\User;

use DateTimeImmutable;

class Token
{
    public function __construct(
        private string $token,
        private DateTimeImmutable $expireAt)
    {
    }

    public function getToket(): string
    {
        return $this->token;
    }

    public function expireAt(): DateTimeImmutable
    {
        return $this->expireAt;
    }
}