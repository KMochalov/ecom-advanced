<?php

namespace App\Auth\Entity\User;
use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Id
{
    #[ORM\Column(type: 'string')]
    #[ORM\Id]
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
}