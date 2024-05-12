<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Auth;

use App\Auth\Command\RegisterByEmail\Request\Command;
use App\Auth\Command\RegisterByEmail\Request\Handler;
use Exception;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class SingupRequestController extends AbstractController
{
    public function __construct(
        private LoggerInterface $logger,
        private Handler $handler
    )
    {
    }

    #[Route(
        '/signup-request',
        name: 'signup-request',
        methods: ['POST'],
        format: 'json'
    )]
    public function request(
        #[MapRequestPayload] Command $command
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
