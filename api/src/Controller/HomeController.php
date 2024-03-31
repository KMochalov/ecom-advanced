<?php

declare(strict_types=1);

namespace App\Controller;

use App\Auth\Command\RegisterByEmail\Request\Command;
use App\Auth\Command\RegisterByEmail\Request\Handler;
use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Id;
use App\Auth\Repository\UserRepository;
use App\Auth\Repository\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Builder\ValidationBuilder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validation;

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

    #[Route('/', name: 'test', format: 'json')]
    public function index(): Response
    {
        return $this->json('asd');
    }
}
