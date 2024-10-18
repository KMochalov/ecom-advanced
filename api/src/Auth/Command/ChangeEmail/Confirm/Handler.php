<?php

namespace App\Auth\Command\ChangeEmail\Confirm;

use App\Auth\Repository\UserRepositoryInterface;
use App\Utils\Flusher;
use DateTimeImmutable;
use DomainException;

class Handler
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly UserRepositoryInterface $repository)
    {
    }

    public function handle(Command $command): void
    {
        $token = $command->token;
        $user = $this->repository->findByChangeEmailToken($token);
        if ($user === null) {
            throw new DomainException('Пользователь с таким токеном не найден');
        }

        $user->confirmChangeEmail($token, new DateTimeImmutable());

        $this->flusher->flush();
    }
}
