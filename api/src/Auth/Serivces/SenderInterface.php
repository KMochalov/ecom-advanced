<?php

namespace App\Auth\Serivces;
use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Token;
interface SenderInterface
{
    public function send(Email $email, Token $token): void;
}