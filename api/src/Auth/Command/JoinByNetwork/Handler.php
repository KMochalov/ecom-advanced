<?php

declare(strict_types=1);

namespace App\Auth\Command\JoinByNetwork;

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
        $email = new Email($command->email);

        if (!$this->repository->existByNetwork($networkIdentity)) {
            throw new DomainException('Эта соцсеть уже привязана для этого пользователя');
        }

        if (!$this->repository->existByEmail($email)) {
            throw new DomainException('Пользователь с таким Email уже есть');
        }

        $user = User::joinByNetwork(
            Id::generate(),
            $email,
            new DateTimeImmutable(),
            $networkIdentity,
        );

        $this->repository->save($user);

        $this->flusher->flush();
    }
}
