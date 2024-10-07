<?php

namespace App\Auth\Repository;

use App\Entity\Email;
use App\Auth\Entity\User\Id;
use App\Auth\Entity\User\NetworkIdentity;
use App\Auth\Entity\User\User;
use DomainException;

interface UserRepositoryInterface
{
    public function add(User $user): void;
    public function existByEmail(Email $email): bool;
    public function findByEmail(Email $email): ?User;
    public function findByConfirmToken(string $token): ?User;
    public function findByChangeEmailToken(string $token): ?User;
    public function findByResetToken(string $token): ?User;
    public function existByNetworkIdentity(string $network, string $identity): bool;

    /**
     * @param Id $id
     * @throws DomainException
     * @return User
     */
    public function get(Id $id): User;
}
