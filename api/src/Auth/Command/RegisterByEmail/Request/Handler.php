<?php

declare(strict_types=1);

namespace App\Auth\Command\RegisterByEmail\Request;

use App\Auth\Entity\User\Email;
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
        private SenderInterface $sender,
        private TokenizerInterface $tokenizer,
        private HasherInterface $hasher,
        //private Flusher $flusher,
        private Flusher $flusher,
    )
    {
    }

    public function handle(Command $command): void
    {
        $email = new Email($command->email);

        if (!$this->repository->existByEmail($email)) {
            throw new DomainException('Такая почта уже используется');
        }

        $now = new DateTimeImmutable();

        $user = User::requestRegisterByEmail(
            Id::generate(),
            $email,
            $now,
            $this->hasher->hash($command->password),
            $token = $this->tokenizer->tokenize($now)
        );

        $this->repository->save($user);
        $this->flusher->flush();
        $this->sender->send($email, $token);
    }
}
