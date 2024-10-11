<?php

declare(strict_types=1);

namespace App\Auth\Command\ResetPassword\Request;

use App\Entity\Email;
use App\Auth\Repository\UserRepositoryInterface;
use App\Auth\Services\SenderInterface;
use App\Auth\Services\TokenizerInterface;
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

        $existingToken = $user->getResetToken();
        if ($existingToken
            && ($diff = $existingToken->getDifferenceInSeconds($token)) < 60
        ) {
            throw new DomainException("Письмо для восстановления пароля уже направлено на почту.
                Если письмо не пришло, попробуйте отправить еще 1 запрос через" . 60 - $diff . " секунд");
        }

        $user->requestResetPassword($token);

        $this->repository->add($user);
        $this->flusher->flush();
        $this->sender->send($email, $token);
    }
}
