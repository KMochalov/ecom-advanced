<?php

namespace App\Auth\Repository;

use App\Auth\Entity\User\Accesstoken;
use App\Auth\Entity\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AccesstokenRepository
{
    private EntityRepository $repository;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
        $this->repository = $this->entityManager->getRepository(Accesstoken::class);
    }

    public function add(Accesstoken $accesstoken): void
    {
        $this->entityManager->persist($accesstoken);
    }

    public function findOne(string $token): ?Accesstoken
    {
        return $this->repository->findOneBy(['token' => $token]);
    }
}
