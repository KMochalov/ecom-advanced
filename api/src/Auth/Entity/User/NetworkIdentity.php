<?php

declare(strict_types=1);

namespace App\Auth\Entity\User;

use Webmozart\Assert\Assert;

class NetworkIdentity
{
    private string $network;
    private string $identity;

    public function __construct(string $network, string $identity)
    {
        Assert::notEmpty($network);
        Assert::notEmpty($identity);

        $this->network = mb_strtolower($network);
        $this->identity = mb_strtolower($identity);
    }

    public function getNetwork(): string
    {
        return $this->network;
    }

    public function getIdentity(): string
    {
        return $this->identity;
    }

    public function isEqualTo(NetworkIdentity $networkIdentity): bool
    {
        return $this->getNetwork() === $networkIdentity->getNetwork()
            && $this->getIdentity() === $networkIdentity->getIdentity();
    }
}
