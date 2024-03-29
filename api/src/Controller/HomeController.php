<?php

declare(strict_types=1);

namespace App\Controller;

use App\Auth\Command\RegisterByEmail\Request\Command;
use App\Auth\Command\RegisterByEmail\Request\Handler;
use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Id;
use App\Auth\Repository\UserRepository;
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
        private UserRepository $repository,
    ) {

    }


    #[Route('/', name: 'test', format: 'json')]
    public function index(): Response
    {
        $command = new Command();

        $command->email = '';

        $command->password = '';

        $validation = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $violations = $validation->validate($command);

        if ($violations->count()) {
            foreach ($violations as $violation) {
                echo $violation->getPropertyPath() . ' - ' . $violation->getMessage() . PHP_EOL;
            }
        }

    //    $user = $this->repository->existByNetworkIdentity('vk', '123');
        return $this->json('asd');
    }
}
