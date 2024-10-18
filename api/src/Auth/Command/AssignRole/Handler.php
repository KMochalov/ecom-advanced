<?php

declare(strict_types=1);

namespace App\Auth\Command\AssignRole;

use App\Auth\Entity\User\Role;
use App\Auth\Repository\UserRepositoryInterface;
use App\Entity\Id;
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
