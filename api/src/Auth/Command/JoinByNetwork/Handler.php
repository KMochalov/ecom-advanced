<?php

declare(strict_types=1);

namespace App\Auth\Command\JoinByNetwork;

use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Id;
use App\Auth\Entity\User\NetworkIdentity;
use App\Auth\Entity\User\Status;
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
        if (empty($command->email)) {
            $command->email = $command->identity . '@' . $command->network . 'ru';
        }

        $email = new Email($command->email);

        if (!$this->repository->existByEmail($email)) {
            throw new DomainException('Пользователь с таким Email уже есть');
        }

        $user = new User(
            Id::generate(),
            $email,
            new DateTimeImmutable(),
            Status::active()
        );

        $networkIdentity =  new NetworkIdentity(
            Id::generate(),
            $user,
            $command->network,
            $command->identity
        );

        if ($this->repository->existByNetworkIdentity($networkIdentity->getNetwork(), $networkIdentity->getIdentity())) {
            throw new DomainException('Пользователь с такой соцсетью есть');
        }

        $user->attachNetwork($networkIdentity);

        $this->repository->add($user);

        $this->flusher->flush();
    }
}
