<?php

declare(strict_types=1);

namespace App\Auth\Command\ChangeEmail\Request;

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
        private Flusher $flusher,
    )
    {
    }

    public function handle(Command $command): void
    {
        $newEmail = new Email($command->newEmail);

        $user = $this->repository->get(new Id($command->userId));
        $token = $this->tokenizer->tokenize($date = new DateTimeImmutable());

        $user->changeEmailRequest($newEmail, $date, $token);

        $this->repository->add($user);
        $this->flusher->flush();
        $this->sender->send($newEmail, $token);
    }
}
