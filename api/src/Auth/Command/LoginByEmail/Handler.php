<?php

namespace App\Auth\Command\LoginByEmail;

use App\Auth\Entity\User\Accesstoken;
use App\Entity\Id;
use App\Auth\Repository\AccesstokenRepository;
use App\Auth\Repository\UserRepository;
use App\Security\UserIdentity;
use App\Utils\Flusher;
use Ramsey\Uuid\Uuid;

class Handler
{
    public function __construct(
        private UserRepository $userRepository,
        private AccesstokenRepository $accesstokenRepository,
        private Flusher $flusher
    ){}

    public function handle(UserIdentity $userIdentity): Accesstoken
    {
        $user = $this->userRepository->get(new Id($userIdentity->getId()));
        $token = new Accesstoken(
            Id::generate(),
            $user,
            Uuid::uuid4()->toString(),
            (new \DateTimeImmutable())->modify('+1 month'),
        );
        $this->accesstokenRepository->add($token);
        $this->flusher->flush();

        return $token;
    }
}