<?php

namespace App\Cabinet\Command\ChangeEmail;

use App\Entity\Email;
use App\Entity\Id;

class Command
{
    public function __construct(
        public readonly Id $userId,
        public readonly Email $newEmail
    )
    {
    }
}