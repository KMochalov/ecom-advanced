<?php

declare(strict_types=1);

namespace App\Auth\Command\ChangePassword;

use App\Auth\Entity\User\Id;
use App\Auth\Repository\UserRepositoryInterface;
use App\Auth\Serivces\HasherInterface;
use App\Utils\Flusher;

class Handler
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private HasherInterface $hasher,
        private Flusher $flusher
    )
    {
    }
    public function handle(Command $command)
    {
       $user = $this->repository->get(new Id($command->userId));

       $user->changePassword($command->old, $command->new, $this->hasher);

       $this->flusher->flush();
    }
}