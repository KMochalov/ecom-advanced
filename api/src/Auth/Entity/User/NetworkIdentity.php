<?php

declare(strict_types=1);

namespace App\Auth\Entity\User;

use Webmozart\Assert\Assert;
use App\Auth\Entity\User\Id;

class NetworkIdentity
{
    private Id $id;
    private User $user;
    private string $network;
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
