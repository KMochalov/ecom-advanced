<?php

namespace App\Auth\Entity\User;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Entity]
#[ORM\Table(name: 'access_tokens')]
#[ORM\UniqueConstraint(name: "token", columns: ["token"])]
class Accesstoken
{
    #[ORM\Column(type: 'user_id')]
    #[ORM\Id]
    private Id $id;
    #[ORM\ManyToOne(targetEntity: 'User', inversedBy: 'accesstokens')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private User $user;

    #[ORM\Column(nullable: false, name: 'expires_at', type: 'date_immutable')]
    private DateTimeImmutable $expiresAt;

    #[ORM\Column(length: 68, type: 'string', nullable: false)]
    private string $token;

    public function __construct(Id $id, User $user, string $token, DateTimeImmutable $expiresAt)
    {
        $this->id = $id;
        $this->user = $user;
        $this->token = $token;
        $this->expiresAt = $expiresAt;
    }
    public function getId(): Id
    {
        return $this->id;
    }
    public function getUser(): User
    {
        return $this->user;
    }

    public function setUserId(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getExpiresAt(): ?DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(DateTimeImmutable $expiresAt): static
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function isValid(): bool
    {
        return $this->expiresAt > new DateTimeImmutable();
    }
}
