<?php

namespace App\Auth\Entity\User;

use App\Auth\Repository\UserRepository;
use ArrayObject;
use DateTimeImmutable;
use DomainException;

class User
{
    private ?Token $token = null;
    private ?string $passwordHash = null;
    private Role $role;


    public function __construct(
        private Id $id,
        private Email $email,
        private DateTimeImmutable $createdAt,
        private Status $status,
        private ArrayObject $networks = new ArrayObject()
    )
    {
        $this->role = Role::makeUser();
    }

    public static function requestRegisterByEmail(
         Id $id,
         Email $email,
         DateTimeImmutable $createdAt,
         string $passwordHash,
         Token $token,
    ): self
    {
        $user = new User(
            $id,
            $email,
            $createdAt,
            Status::inActive()
        );

        $user->passwordHash = $passwordHash;
        $user->token = $token;

        return $user;
    }

    public function attachNetwork(NetworkIdentity $networkIdentity): void
    {
        foreach ($this->networks as $attachedNetwork) {
            if ($networkIdentity->isEqualTo($attachedNetwork)) {
                throw new DomainException('Эта соцсеть уже привязана к этому пользователю');
            }
        }

        $this->networks->append($networkIdentity);
    }

    public static function joinByNetwork(
        Id $id,
        Email $email,
        DateTimeImmutable $createdAt,
        NetworkIdentity $networkIdentity
    ): self
    {
        $user = new User(
            $id,
            $email,
            $createdAt,
            Status::active()
        );

        $user->appendNetwork($networkIdentity);

        return $user;
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

    public function appendNetwork(NetworkIdentity $networkIdentity): void
    {
        $this->networks->append($networkIdentity);
    }

    public function getNetworks(): array
    {
        return $this->networks->getArrayCopy();
    }

    public function changeRole(Role $role): void
    {
        if ($this->role->isEqual($role)) {
            throw new DomainException('Эта роль уже установлена для пользователя');
        }

        $this->role = $role;
    }
}
