<?php

namespace App\Auth\Entity\User;
use Ramsey\Uuid\Uuid;

class Id
{
    private string $id;
    public function __construct(string $id)
    {
        if (!$id) {
            throw new \DomainException('Id не может быть пустым');
        }

        $this->id = mb_strtolower($id);
    }

    public static function generate(): Id
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function getId(): string
    {
        return $this->id;
    }
}