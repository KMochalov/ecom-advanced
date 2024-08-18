<?php

namespace App\Cabinet\Fetcher;

use App\Cabinet\Entity\Profile;
use App\Cabinet\Repository\ProfileRepository;
use App\Entity\Id;
use Doctrine\ORM\EntityManagerInterface;

class UserProfileFetcher
{
    public function __construct(private ProfileRepository $profileRepository)
    {
    }

    public function fetch(string $userId): Profile
    {
        return $this->profileRepository->getProfileByUserId($userId);
    }
}