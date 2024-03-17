<?php

namespace App\Auth\Serivces;

use App\Auth\Entity\User\Token;
use DateTimeImmutable;

interface TokenizerInterface
{
    public function tokenize(DateTimeImmutable $now): Token;
}