<?php

namespace App\Auth\Serivces;

use App\Auth\Serivces\HasherInterface;

class Hasher implements HasherInterface
{
    public function hash(string $password): string
    {
       return password_hash($password, PASSWORD_ARGON2I);
    }

    public function validate(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}