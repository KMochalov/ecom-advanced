<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Auth;

use App\Auth\Command\LoginByEmail\Handler as LoginHandler;
use App\Auth\Command\ResetPassword\Reset\Command;
use App\Auth\Command\ResetPassword\Reset\Handler;
use App\Security\UserIdentity;
use App\Security\UserProvider;
use Exception;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class ResetPasswordConfirmController extends AbstractController
{
    public function __construct(
        private LoggerInterface $logger,
        private Handler $handler,
    )
    {
    }

    #[Route(
        '/auth/reset-password-confirm',
        name: 'auth.reset-password-confirm',
        methods: ['POST'],
        format: 'json'
    )]
    public function confirm(
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
