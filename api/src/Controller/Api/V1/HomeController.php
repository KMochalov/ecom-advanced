<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Auth\Repository\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @psalm-suppress UnusedClass
 */
class HomeController extends AbstractController
{
    public function __construct(
        private UserRepositoryInterface $repository,
    )
    {
    }

    #[Route('/test', name: 'test', format: 'json')]
    public function index(): Response
    {
        $userIdentity = $this->getUser();
        return $this->json('asd');
    }
}
