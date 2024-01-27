<?php

namespace App\Auth\Serivces;

interface HasherInterface
{
    public function hash(string $password): string;
}