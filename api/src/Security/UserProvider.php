<?php

declare(strict_types=1);

namespace App\Security;

use App\Auth\Entity\User\Email;
use App\Auth\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface, PasswordUpgraderInterface
{
    public function __construct(private UserRepositoryInterface $repository){

    }

    public function refreshUser(UserInterface $user)
    {
        return $user;

//        $user = $this->repository->findByEmail(new Email($user->getUserIdentifier()));
//
//        if (null === $user) {
//            throw new UserNotFoundException();
//        }
//
//        return new UserIdentity(
//            [$user->getRole()->getRole()],
//            $user->getId()->getValue(),
//            $user->getEmail()->getValue(),
//            $user->getPasswordHash()
//        );
    }

    public function supportsClass(string $class): bool
    {
        return UserIdentity::class === $class;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->repository->findByEmail(new Email($identifier));

        if (null === $user) {
            throw new UserNotFoundException();
        }

        return new UserIdentity(
            [$user->getRole()->getRole()],
            $user->getId()->getValue(),
            $user->getEmail()->getValue(),
            $user->getPasswordHash()
        );
    }

    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        // TODO: Implement upgradePassword() method.
    }
}
