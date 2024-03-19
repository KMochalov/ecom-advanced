<?php

namespace App\Auth\Repository;

use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Id;
use App\Auth\Entity\User\NetworkIdentity;
use App\Auth\Entity\User\User;
use DomainException;

interface UserRepositoryInterface
{
    public function save(User $user): void;
    public function existByEmail(Email $email): bool;
    public function findByEmail(Email $email): ?User;
    public function findByToken(string $token): ?User;
    public function existByNetwork(NetworkIdentity $networkIdentity): bool;

    /**
     * @param Id $id
     * @throws DomainException
     * @return User
     */
    public function get(Id $id): User;
}
