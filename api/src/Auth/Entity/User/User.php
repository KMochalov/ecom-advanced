<?php

namespace App\Auth\Entity\User;

use DateTimeImmutable;
use DomainException;

class User
{
    private Status $status;
    public function __construct(
        private  Id $id,
        private Email $email,
        private DateTimeImmutable $createdAt,
        private string $passwordHash,
        private ?Token $token,
    )
    {
        $this->status = Status::inActive();
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function getToken(): Token
    {
        return $this->token;
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function confirmJoin(string $token, DateTimeImmutable $date): void
    {
        if ($this->token === null) {
            throw new DomainException('Подтверждение не требуется.');
        }

        $this->token->validate($token, $date);
        $this->status->makeActive();
        $this->token = null;
    }
}