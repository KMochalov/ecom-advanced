<?php

declare(strict_types=1);

namespace App\Auth\Entity\User;

use DomainException;
use Webmozart\Assert\Assert;

class Role
{
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    public function __construct(
        private readonly string $role
    )
    {
        Assert::oneOf($this->role, [self::ROLE_USER, self::ROLE_ADMIN], "Передана неверная роль");
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public static function makeUser(): self
    {
        return new self(self::ROLE_USER);
    }

    public static function makeAdmin(): self
    {
        return new self(self::ROLE_ADMIN);
    }

    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isEqual(Role $role): bool
    {
        return $this->role === $role->getRole();
    }
}
