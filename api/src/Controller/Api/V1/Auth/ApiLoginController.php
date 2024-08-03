<?php

namespace App\Controller\Api\V1\Auth;

use App\Auth\Command\LoginByEmail\Handler;
use App\Auth\Entity\User\Id;
use App\Auth\Repository\UserRepository;
use App\Security\UserIdentity;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Auth\Entity\User\Accesstoken;
use App\Auth\Repository\AccesstokenRepository;
use App\Utils\Flusher;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ApiLoginController extends AbstractController
{
    public function __construct(
        private Handler $handler
    ){}
    #[Route('/login', name: 'api_login', methods: ['POST'])]
    public function login(#[CurrentUser] ?UserIdentity $userIdentity): Response
    {
        if (null === $userIdentity) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $this->handler->handle($userIdentity);

        return $this->json([
            'token' => $token->getToken()
        ]);
    }
}