<?php

namespace App\Auth\Entity\User;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Status
{
    public const ACTIVE = 'active';
    public const IN_ACTIVE = 'inactive';

    #[ORM\Column(type: 'string')]
    private string $status;

    private function __construct(bool $status = self::IN_ACTIVE)
    {
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