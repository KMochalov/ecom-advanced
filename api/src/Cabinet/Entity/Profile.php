<?php

namespace App\Cabinet\Entity;

use App\Entity\Email;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Id;

#[ORM\Entity]
#[ORM\Table(name: 'user_profiles')]
#[ORM\HasLifecycleCallbacks]
#[ORM\UniqueConstraint(name: "user_id", columns: ["user_id"])]
class Profile
{
    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $name;
    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $photo;

    public function __construct(
       #[ORM\Column(type: 'uuid', unique: true)]
       #[ORM\Id]
       private Id $id,
       #[ORM\Column(type: 'uuid', unique: true)]
       private Id $user_id,
       #[ORM\Column(type: 'email', nullable: true)]
       private Email $email,
    ) {

    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): void
    {
        $this->photo = $photo;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function setEmail(Email $email): void
    {
        $this->email = $email;
    }


    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id->getValue(),
            'name' => $this->name,
            'photo' => $this->photo,
            'email' => $this->email->getValue()
        ];
    }
}
