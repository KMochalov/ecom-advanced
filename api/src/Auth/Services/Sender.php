<?php

namespace App\Auth\Services;

use App\Auth\Entity\User\Email as UserEmail;
use App\Auth\Entity\User\Token;
use App\Auth\Services\SenderInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email as SymfonyEmail;

class Sender implements SenderInterface
{

    public function __construct(private MailerInterface $mailer, private string $senderEmail)
    {
    }

    public function send(UserEmail $userEmail, Token $token): void
    {
        $body ='Подтвердите регистрацию на сайте' . '/signup/confirm?' . http_build_query(['token' => $token->getValue()]);
        $email = new SymfonyEmail();
        $email->from($this->senderEmail)
            ->to($userEmail->getValue())
            ->subject('Подтверждение регистрации')
            ->html($body);

        $this->mailer->send($email);
    }
}
