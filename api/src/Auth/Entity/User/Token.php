<?php

namespace App\Auth\Entity\User;

use DateTimeImmutable;
use DomainException;
use Webmozart\Assert\Assert;

class Token
{
    public function __construct(
        private string $token,
        private DateTimeImmutable $expireAt)
    {
        Assert::uuid($this->token);
    }

    public function getValue(): string
    {
        return $this->token;
    }

    public function expireAt(): DateTimeImmutable
    {
        return $this->expireAt;
    }

    public function validate(string $token, DateTimeImmutable $date): bool
    {
        if ($this->token !== $token) {
            throw new DomainException('Токены не совпадают');
        }

        if ($this->expireAt < $date) {
            throw new DomainException('Срок действия токена истёк.');
        }

        return true;
    }
}