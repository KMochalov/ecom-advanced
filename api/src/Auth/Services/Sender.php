<?php

namespace App\Auth\Services;

use App\Entity\Email as UserEmail;
use App\Auth\Entity\User\Token;
use App\Auth\Services\SenderInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email as SymfonyEmail;

class Sender implements SenderInterface
{

    public function __construct(
        private MailerInterface $mailer,
        private string $senderEmail,
        private string $frontendUrl)
    {
    }

    public function send(UserEmail $userEmail, Token $token): void
    {
        $link = $this->frontendUrl
            . '/signup-confirm?'
            . http_build_query(['token' => $token->getValue()]);

        $body ='Подтвердите регистрацию на сайте '
            . "<a href='{$link}'>{$link}</a>";


        $email = new SymfonyEmail();
        $email->from($this->senderEmail)
            ->to($userEmail->getValue())
            ->subject('Подтверждение регистрации')
            ->html($body);

        $this->mailer->send($email);
    }
}
