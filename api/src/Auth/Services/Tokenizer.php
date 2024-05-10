<?php

namespace App\Auth\Services;

use App\Auth\Entity\User\Token;
use App\Auth\Services\TokenizerInterface;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

class Tokenizer implements TokenizerInterface
{
    public function tokenize(DateTimeImmutable $now): Token
    {
       $expireAt = $now->modify('+1 day');

       return new Token(Uuid::uuid4()->toString(), $expireAt);
    }
}
