<?php

namespace App\Cabinet\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Id;

#[ORM\Entity]
#[ORM\Table(name: 'user_profiles')]
#[ORM\HasLifecycleCallbacks]
#[ORM\UniqueConstraint(name: "user_id", columns: ["user_id"])]
class Profile
{
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\Id]
    private Id $id;
    #[ORM\Column(type: 'uuid', unique: true)]
    private Id $user_id;
    #[ORM\Column(type: 'string')]
    private string $name;
    #[ORM\Column(type: 'string')]
    private string $photo;

    public function __construct(
        string $id,
        string $user_id
    )
    {
        $this->id = $id;
        $this->user_id = $user_id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPhoto(): string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): void
    {
        $this->photo = $photo;
    }
}