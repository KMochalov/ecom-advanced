<?php

namespace App\Auth\Entity\User;

use DateTimeImmutable;
use DomainException;
use Webmozart\Assert\Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Token
{
    public function __construct(
        #[ORM\Column(type: 'string', nullable: true)]
        private string $token,
        #[ORM\Column(type: 'date_immutable', nullable: true)]
        private DateTimeImmutable $expireAt
    )
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