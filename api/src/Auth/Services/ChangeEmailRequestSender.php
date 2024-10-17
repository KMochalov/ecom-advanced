<?php

namespace App\Auth\Services;

use App\Auth\Entity\User\Token;
use App\Entity\Email as UserEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email as SymfonyEmail;

class ChangeEmailRequestSender implements SenderInterface
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
                . '/reset-password?'
                . http_build_query(['token' => $token->getValue()]);

        $body ='Вам направлена ссылка для смены Email. НЕ ПЕРЕХОДИТЬ ЕСЛИ ЭТО НЕ ВЫ '
            . "<a href='{$link}'>{$link}</a>";

        $email = new SymfonyEmail();
        $email->from($this->senderEmail)
            ->to($userEmail->getValue())
            ->subject('Смена Email')
            ->html($body);

        $this->mailer->send($email);
    }
}