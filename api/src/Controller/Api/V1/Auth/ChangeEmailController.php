<?php

namespace App\Controller\Api\V1\Auth;

use App\Auth\Command\ChangeEmail\Request\Command as CommandRequest;
use App\Auth\Command\ChangeEmail\Request\Handler as HandlerRequest;
use App\Auth\Command\ChangeEmail\Confirm\Command as CommandConfirm;
use App\Auth\Command\ChangeEmail\Confirm\Handler as HandlerConfirm;
use Exception;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class ChangeEmailController extends AbstractController
{
    public function __construct(
        private HandlerRequest  $handlerRequest,
        private HandlerConfirm  $handlerConfrim,
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
    public function request(
        #[MapRequestPayload] CommandRequest $command
    ): Response
    {
        try {
            $this->handlerRequest->handle($command);
        } catch (Exception $exception) {
            $this->logger->log(LogLevel::INFO, $exception->getMessage(), ['exception' => $exception]);
            throw $exception;
        }

        return new Response('', 201);
    }

    #[Route(
        '/auth/change-email-confirm',
        name: 'auth.change-email-confirm',
        methods: ['POST'],
        format: 'json'
    )]
    public function confirm(
        #[MapRequestPayload] CommandConfirm $command
    ): Response
    {
        try {
            $this->handlerConfrim->handle($command);
        } catch (Exception $exception) {
            $this->logger->log(LogLevel::INFO, $exception->getMessage(), ['exception' => $exception]);
            throw $exception;
        }

        return new Response('', 201);
    }
}