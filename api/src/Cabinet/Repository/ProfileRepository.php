<?php

namespace App\Cabinet\Repository;

use App\Cabinet\Entity\Profile;
use App\Entity\Id;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ProfileRepository
{
    private EntityRepository $repository;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
        $this->repository = $this->entityManager->getRepository(Profile::class);
    }

    public function add(Profile $profile): void
    {
        $this->entityManager->persist($profile);
    }

    public function existByUserId(Id $userId): bool
    {
        return (bool) $this->repository->findOneBy(['user_id' => $userId->getValue()]);
    }

    public function getProfileByUserId(string $userId): ?Profile
    {
        return $this->repository->findOneBy(['user_id' => $userId]);
    }

}