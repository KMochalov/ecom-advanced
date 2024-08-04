<?php

namespace App\Controller\Api\V1\Auth;

use App\Auth\Command\JoinByNetwork\Command;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    public function __construct(private Security $security)
    {
    }

    #[Route(
        '/profile',
        name: 'profile',
        methods: ['GET'],
    )]
    public function getProfile(): Response
    {
        $user = $this->security->getUser();

        return $this->json([$user]);
    }
}