<?php

declare(strict_types=1);

namespace App\Auth\RegisterByEmail\Request;

class Command
{
    public string $email;
    public string $password;
}
