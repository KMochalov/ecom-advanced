<?php

namespace App\Cabinet\Entity;

use App\Cabinet\Entity\Id;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DomainException;


#[ORM\Entity]
#[ORM\Table(name: 'user_profiles')]
#[ORM\HasLifecycleCallbacks]
#[ORM\UniqueConstraint(name: "user_id", columns: ["user_id"])]
class Profile
{
    #[ORM\Column(type: 'string')]
    #[ORM\Id]
    private string $id;
    #[ORM\Column(type: 'string')]
    private string $user_id;
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