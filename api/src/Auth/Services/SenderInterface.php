<?php

namespace App\Auth\Services;
use App\Entity\Email;
use App\Auth\Entity\User\Token;
interface SenderInterface
{
    public function send(Email $email, Token $token): void;
}
