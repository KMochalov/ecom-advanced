<?php

namespace App\Auth\Command\RegisterByEmail\ConfirmJoin;

use App\Auth\Entity\User\User;
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

    public function handle(Command $command): User
    {
        $token = $command->token;
        $user = $this->repository->findByConfirmToken($token);
        if ($user === null) {
            throw new DomainException('Пользователь с таким токеном не найден');
        }
        $user->confirmJoin($token, new DateTimeImmutable());

        $this->flusher->flush();

        return $user;
    }
}
