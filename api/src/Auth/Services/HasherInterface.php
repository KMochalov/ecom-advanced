<?php

namespace App\Auth\Services;

interface HasherInterface
{
    public function hash(string $password): string;
    public function validate(string $password, string $hash): bool;
}
