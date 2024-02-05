<?php

declare(strict_types=1);

namespace App\Auth\Command\AttachNetwork;

use App\Auth\Command\AttachNetwork\Command;
use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Id;
use App\Auth\Entity\User\NetworkIdentity;
use App\Auth\Entity\User\User;
use App\Auth\Repository\UserRepositoryInterface;
use App\Utils\Flusher;
use DateTimeImmutable;
use DomainException;

class Handler
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private Flusher $flusher
    )
    {
    }

    public function handle(Command $command): void
    {
        $networkIdentity = new NetworkIdentity($command->network, $command->identity);

        $user = $this->repository->get(new Id($command->id));

        $user->attachNetwork($networkIdentity);

        $this->flusher->flush();
    }

}
