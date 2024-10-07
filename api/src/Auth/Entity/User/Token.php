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
        #[ORM\Column(type: 'datetime_immutable', nullable: true)]
        private DateTimeImmutable $expireAt
    )
    {
        Assert::uuid($this->token);
    }

    public function getValue(): ?string
    {
        return $this->token ?? null;
    }

    public function expireAt(): ?DateTimeImmutable
    {
        return $this->expireAt ?? null;
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

    public function expired(DateTimeImmutable $date): bool{
        return $date > $this->expireAt;
    }

    public function getDifferenceInSeconds(self $token): int
    {
        return $token->expireAt->getTimestamp() - $this->expireAt->getTimestamp();
    }
}
