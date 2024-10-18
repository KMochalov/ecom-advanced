<?php

declare(strict_types=1);

namespace App\Auth\Repository;

use App\Entity\Email;
use App\Entity\Id;
use App\Auth\Entity\User\NetworkIdentity;
use App\Auth\Entity\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserRepository implements UserRepositoryInterface
{
    private EntityRepository $repository;

    public function __construct(
      private readonly EntityManagerInterface $entityManager,
    ) {
        $this->repository = $this->entityManager->getRepository(User::class);
    }

    public function add(User $user): void
    {
        $this->entityManager->persist($user);
    }

    public function existByEmail(Email $email): bool
    {
        return (bool) $this->repository->findOneBy(['email' => $email->getValue()]);
    }

    public function findByConfirmToken(string $token): ?User
    {
        return $this->repository->findOneBy(['confirmToken.token' => $token]);
    }

    public function existByNetworkIdentity(string $network, string $identity): bool
    {
        return $this->repository->createQueryBuilder('u')
                ->select('COUNT(u.id)')
                ->innerJoin('u.networks', 'n')
                ->andWhere('n.network = :network and n.identity = :identity')
                ->setParameter(':network', $network)
                ->setParameter(':identity', $identity)
                ->getQuery()
                ->getSingleScalarResult() > 0;
    }

    public function get(Id $id): User
    {
        $user = $this->repository->find($id);
        if (!$user) {
            throw new NotFoundHttpException('Пользователь не найден');
        }

        return $user;
    }

    public function findByEmail(Email $email): ?User
    {
        return $this->repository->findOneBy(['email' => $email->getValue()]);
    }

    public function findByResetToken(string $token): ?User
    {
        return $this->repository->findOneBy(['resetToken.token' => $token]);
    }

    public function findByChangeEmailToken(string $token): ?User
    {
        return $this->repository->findOneBy(['changeEmailToken.token' => $token]);
    }
}
