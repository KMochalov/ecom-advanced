<?php

declare(strict_types=1);

namespace App\Auth\Command\ResetPassword\Reset;

use App\Auth\Repository\UserRepositoryInterface;
use App\Auth\Serivces\Hasher;
use App\Utils\Flusher;
use DateTimeImmutable;
use DomainException;

class Handler
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private Flusher $flusher,
        private Hasher $hasher
    )
    {
    }

    public function handle(Command $command): void
    {
        if (!$user = $this->repository->findByResetToken($command->token)) {
            throw new DomainException('Токена не существует');
        }

        $user->resetPassword(
            date: new DateTimeImmutable(),
            hash: $this->hasher->hash($command->password),
            token: $command->token
        );

        $this->repository->save($user);
        $this->flusher->flush();
    }
}
