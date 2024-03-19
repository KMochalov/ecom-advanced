<?php

declare(strict_types=1);

namespace App\Auth\Command\ResetPassword\Request;

use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Id;
use App\Auth\Entity\User\User;
use App\Auth\Repository\UserRepositoryInterface;
use App\Auth\Serivces\HasherInterface;
use App\Auth\Serivces\SenderInterface;
use App\Auth\Serivces\TokenizerInterface;
use App\Utils\Flusher;
use DateTimeImmutable;
use DomainException;

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
        $email = new Email($command->email);

        if (!$user = $this->repository->findByEmail($email)) {
            throw new DomainException('Пользователя с такой почтой не зарегистрированно');
        }

        $now = new DateTimeImmutable();
        $token = $this->tokenizer->tokenize($now);

        $user->requestResetPassword($token);

        $this->repository->save($user);
        $this->flusher->flush();
        $this->sender->send($email, $token);
    }
}
