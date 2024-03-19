<?php

declare(strict_types=1);

namespace App\Auth\Command\Role;

use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Role;
use App\Auth\Entity\User\User;
use App\Auth\Repository\UserRepositoryInterface;
use App\Auth\Serivces\HasherInterface;
use App\Auth\Serivces\SenderInterface;
use App\Auth\Serivces\TokenizerInterface;
use DateTimeImmutable;
use DomainException;
use App\Auth\Entity\User\Id;
use App\Utils\Flusher;

class Handler
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private Flusher $flusher,
    )
    {
    }

    public function handle(Command $command): void
    {
        $user = $this->repository->get(new Id($command->userId));

        $role = new Role($command->role);

        $user->changeRole($role);

        $this->flusher->flush();
    }
}
