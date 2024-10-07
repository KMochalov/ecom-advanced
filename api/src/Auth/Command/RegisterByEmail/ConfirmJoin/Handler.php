<?php

namespace App\Auth\Command\RegisterByEmail\ConfirmJoin;

use App\Auth\Entity\User\User;
use App\Auth\Events\NewUserEvent;
use App\Auth\Repository\UserRepositoryInterface;
use App\Utils\Flusher;
use DateTimeImmutable;
use DomainException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Handler
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly UserRepositoryInterface $repository,
        private EventDispatcherInterface $eventDispatcher,
    )
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
        $this->eventDispatcher->dispatch(new NewUserEvent($user->getId(), $user->getEmail()));

        return $user;
    }
}
