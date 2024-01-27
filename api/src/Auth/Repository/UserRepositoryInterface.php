<?php

namespace App\Auth\Repository;

use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;
    public function existByEmail(Email $email): bool;
}