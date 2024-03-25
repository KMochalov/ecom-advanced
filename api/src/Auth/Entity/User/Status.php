<?php

namespace App\Auth\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
class Status
{
    public const ACTIVE = 'active';
    public const IN_ACTIVE = 'inactive';

    #[ORM\Column(type: 'string')]
    private string $status;

    public function __construct(string $status = self::IN_ACTIVE)
    {
        Assert::oneOf($status, [
            self::IN_ACTIVE,
            self::ACTIVE,
        ]);
        $this->status = $status;
    }

    public static function inActive(): self
    {
        return new self();
    }

    public static function active(): self
    {
        return new self(self::ACTIVE);
    }

    public function getValue(): string
    {
        return $this->status;
    }

    public function makeActive(): void
    {
        $this->status = self::ACTIVE;
    }

    public function makeInActive(): void
    {
        $this->status = self::IN_ACTIVE;
    }


    public function isActive(): bool
    {
        return $this->status == self::ACTIVE;
    }
}