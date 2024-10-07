<?php

namespace App\Controller\Api\V1\Cabinet;

use App\Cabinet\Fetcher\UserProfileFetcher;
use App\Entity\Email;
use App\Security\UserIdentity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    public function __construct(private Security $security, private UserProfileFetcher $fetcher)
    {
    }

    #[Route(
        '/profile',
        name: 'profile',
        methods: ['GET'],
    )]
    public function getProfile(): Response
    {
        /** @var UserIdentity $user */
        $user = $this->security->getUser();
        $profile = $this->fetcher->fetch($user->getId());
        return $this->json($profile->toArray());
    }
}
