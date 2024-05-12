<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Auth;

use App\Auth\Command\RegisterByEmail\ConfirmJoin\Command;
use App\Auth\Command\RegisterByEmail\ConfirmJoin\Handler;
use Exception;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Annotation\Route;

class SignupConfirmController extends AbstractController
{
    public function __construct(
        private LoggerInterface $logger,
        private Handler $handler
    )
    {
    }

    #[Route(
        '/signup-confirm',
        name: 'signup-confirm',
        methods: ['GET'],
        format: 'json'
    )]
    public function confirm(
        #[MapQueryString] Command $command
    ): Response
    {
        try {
            $this->handler->handle($command);
        } catch (Exception $exception) {
            $this->logger->log(LogLevel::INFO, $exception->getMessage(), ['exception' => $exception]);
            throw $exception;
        }

        return new Response('', 201);
    }
}
