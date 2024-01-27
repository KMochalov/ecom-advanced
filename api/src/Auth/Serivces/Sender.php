<?php

namespace App\Auth\Serivces;

use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Token;
use App\Auth\Serivces\SenderInterface;

class Sender implements SenderInterface
{
    public function send(Email $email, Token $token): void
    {
        // TODO: Implement send() method.
    }
}