<?php

namespace App\Auth\Entity\User;

class Status
{
    public const ACTIVE = true;
    public const IN_ACTIVE = false;

    private bool $status;

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

    public function getValue(): bool
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