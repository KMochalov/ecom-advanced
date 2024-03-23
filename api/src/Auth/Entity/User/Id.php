<?php

namespace App\Auth\Entity\User;
use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

class Id
{
    private string $id;

    public function __construct(string $id)
    {
        Assert::uuid($id);
        $this->id = mb_strtolower($id);
    }

    public static function generate(): Id
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function getValue(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}