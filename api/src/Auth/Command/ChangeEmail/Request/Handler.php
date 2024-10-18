<?php

declare(strict_types=1);

namespace App\Auth\Command\ChangeEmail\Request;

use App\Auth\Services\ChangeEmailRequestSender;
use App\Entity\Email;
use App\Auth\Entity\User\User;
use App\Auth\Repository\UserRepositoryInterface;
use App\Auth\Services\HasherInterface;
use App\Auth\Services\SenderInterface;
use App\Auth\Services\TokenizerInterface;
use DateTimeImmutable;
use DomainException;
use App\Entity\Id;
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
        $this->flusher->flush();
        $this->sender->send($user->getEmail(), $token);
    }
}
