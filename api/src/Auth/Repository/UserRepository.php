<?php

declare(strict_types=1);

namespace App\Auth\Repository;

use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\User;

class UserRepository implements UserRepositoryInterface
{

    public function save(User $user): void
    {
        // TODO: Implement save() method.
    }

    public function existByEmail(Email $email): bool
    {
        // TODO: Implement existByEmail() method.
        return true;
    }

    public function findByToken(string $token): ?User
    {
        // TODO: Implement findByToken() method.
        return null;
    }
}
