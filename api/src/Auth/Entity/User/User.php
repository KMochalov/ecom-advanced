<?php

namespace App\Auth\Entity\User;

use ArrayObject;
use DateTimeImmutable;
use DomainException;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'user_users')]
class User
{
    private ?Token $confirmToken = null;
    private ?Token $resetToken = null;
    private ?string $passwordHash = null;
    private Role $role;
    private Id $id;
    private Email $email;
    private DateTimeImmutable $createdAt;
    private Status $status;
    private ArrayObject $networks;

    public function __construct(
        Id $id,
        Email $email,
        DateTimeImmutable $createdAt,
        Status $status,
        ArrayObject $networks = new ArrayObject()
    )
    {
        $this->role = Role::makeUser();
        $this->id = $id;
        $this->email = $email;
        $this->createdAt = $createdAt;
        $this->status = $status;
        $this->networks = $networks;
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
        $user->confirmToken = $token;

        return $user;
    }

    public function requestResetPassword(Token $token): void
    {
        $this->resetToken = $token;
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

    public function getConfirmToken(): Token
    {
        return $this->confirmToken;
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
        if ($this->confirmToken === null) {
            throw new DomainException('Подтверждение не требуется.');
        }

        $this->confirmToken->validate($token, $date);
        $this->status->makeActive();
        $this->confirmToken = null;
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

    public function resetPassword(DateTimeImmutable $date, string $hash, string $token): void
    {
        $this->resetToken->validate($token, $date);
        $this->resetToken = null;
        $this->passwordHash = $hash;
    }
}
