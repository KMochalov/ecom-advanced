<?php

namespace App\Controller\Api\V1\Auth;

use App\Auth\Command\ChangeEmail\Request\Command;
use App\Auth\Command\ChangeEmail\Request\Handler;
use Exception;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class ChangeEmailRequestController extends AbstractController
{
    public function __construct(
        private Handler $handler,
        private LoggerInterface $logger,
    )
    {
    }

    #[Route(
        '/auth/change-email-request',
        name: 'auth.change-email-request',
        methods: ['POST'],
        format: 'json'
    )]
    public function changeEmail(
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