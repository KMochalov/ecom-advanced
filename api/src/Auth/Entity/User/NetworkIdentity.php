<?php

declare(strict_types=1);

namespace App\Auth\Entity\User;

use Webmozart\Assert\Assert;
use App\Auth\Entity\User\Id;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'user_networks')]
#[ORM\UniqueConstraint(name: "user_network_identity", columns: ["user_id", 'network', "identity"])]
class NetworkIdentity
{
    #[ORM\Column(type: 'user_id')]
    #[ORM\Id]
    private Id $id;
    #[ORM\ManyToOne(targetEntity: 'User', inversedBy: 'networks')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private User $user;
    #[ORM\Column(type: 'string')]
    private string $network;
    #[ORM\Column(type: 'string')]
    private string $identity;

    public function __construct(Id $id, User $user, string $network, string $identity)
    {
        Assert::notEmpty($network);
        Assert::notEmpty($identity);

        $this->id = $id;
        $this->user = $user;
        $this->network = mb_strtolower($network);
        $this->identity = mb_strtolower($identity);
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getNetwork(): string
    {
        return $this->network;
    }

    public function getIdentity(): string
    {
        return $this->identity;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function isEqualTo(NetworkIdentity $networkIdentity): bool
    {
        return $this->getNetwork() === $networkIdentity->getNetwork()
            && $this->getIdentity() === $networkIdentity->getIdentity();
    }
}
