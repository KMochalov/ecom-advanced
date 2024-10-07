<?php

namespace App\Auth\Entity\User;

use App\Auth\Services\HasherInterface;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DomainException;
use App\Entity\Email;

#[ORM\Entity]
#[ORM\Table(name: 'user_users')]
#[ORM\HasLifecycleCallbacks]
#[ORM\UniqueConstraint(name: "email", columns: ["email"])]
#[ORM\UniqueConstraint(name: "confirm_token", columns: ["confirm_token"])]
#[ORM\UniqueConstraint(name: "reset_token", columns: ["reset_token"])]
class User
{
    #[ORM\Embedded(class: Token::class, columnPrefix: "confirm_")]
    private ?Token $confirmToken = null;
    #[ORM\Embedded(class: Token::class, columnPrefix: "reset_")]
    private ?Token $resetToken = null;
    #[ORM\Embedded(class: Token::class, columnPrefix: "change_email_")]
    private ?Token $changeEmailToken = null;
    #[ORM\Column(type: 'string', nullable: true, name: 'password_hash')]
    private ?string $passwordHash = null;
    #[ORM\Column(type: 'user_role')]
    private Role $role;
    #[ORM\Column(type: 'user_id')]
    #[ORM\Id]
    private Id $id;
    #[ORM\Column(type: 'email')]
    private Email $email;
    #[ORM\Column(type: 'email', nullable: true)]
    private ?Email $newEmail;
    #[ORM\Column(type: 'datetime_immutable', name: 'created_at')]
    private DateTimeImmutable $createdAt;
    #[ORM\Embedded(class: Status::class)]
    private Status $status;
    #[ORM\OneToMany(targetEntity: 'NetworkIdentity', mappedBy: 'user', cascade: ['persist'], orphanRemoval: true)]
    private Collection $networks;

    #[ORM\OneToMany(targetEntity: 'Accesstoken', mappedBy: 'user', cascade: ['persist'], orphanRemoval: true)]
    private Collection $accesstokens;

    public function __construct(
        Id $id,
        Email $email,
        DateTimeImmutable $createdAt,
        Status $status,
        ArrayCollection $networks = new ArrayCollection()
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

    public function getResetToken(): ?Token
    {
        return $this->resetToken;
    }

    public function attachNetwork(NetworkIdentity $networkIdentity): void
    {
        foreach ($this->networks as $attachedNetwork) {
            if ($networkIdentity->isEqualTo($attachedNetwork)) {
                throw new DomainException('Эта соцсеть уже привязана к этому пользователю');
            }
        }

        $this->networks->add($networkIdentity);
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
        $this->networks->add($networkIdentity);
    }

    public function getNetworks(): array
    {
        return $this->networks->toArray();
    }

    public function changeRole(Role $role): void
    {
        if ($this->role->isEqual($role)) {
            throw new DomainException('Эта роль уже установлена для пользователя');
        }

        $this->role = $role;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function resetPassword(DateTimeImmutable $date, string $hash, string $token): void
    {
        $this->resetToken->validate($token, $date);
        $this->resetToken = null;
        $this->passwordHash = $hash;
    }

    #[ORM\PostLoad]
    public function postLoad(): void
    {
        if(!$this->confirmToken->getValue()) {
            $this->confirmToken = null;
        }

        if(!$this->resetToken->getValue()) {
            $this->resetToken = null;
        }

        if(!$this->changeEmailToken?->getValue()) {
            $this->changeEmailToken = null;
        }
    }

    public function changePassword(string $old, string $new, HasherInterface $hasher): void
    {
        if(!$this->passwordHash) {
            throw new DomainException('пароля еще нет');
        }

        if(!$hasher->validate($old, $this->passwordHash)) {
            throw new DomainException('Старый пароль введён не верно');
        }

        $this->passwordHash = $hasher->hash($new);
    }

    public function changeEmailRequest(Email $newEmail, DateTimeImmutable $date, Token $token): void
    {
        if (!$this->status->isActive()) {
            throw new DomainException('Пользователь не активен');
        }

        if ($this->changeEmailToken !== null && !$this->changeEmailToken->expired($date)) {
            throw new DomainException('Запрос на смену email уже отправлен');
        }

        if ($this->email->isEqualTo($newEmail)) {
            throw new DomainException('Нелзя менять на старый Email');
        }

        $this->newEmail = $newEmail;
        $this->changeEmailToken = $token;
    }

    public function confirmChangeEmail(string $token, DateTimeImmutable $date): void
    {
        if ($this->changeEmailToken === null || $this->newEmail === null) {
            throw new DomainException('Запроса на смену email не было');
        }

        $this->changeEmailToken->validate($token, $date);
        $this->email = $this->newEmail;
        $this->newEmail = null;
        $this->changeEmailToken = null;
    }
}
