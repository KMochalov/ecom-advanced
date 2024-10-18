<?php

namespace App\Cabinet\Command\ChangeEmail;

use App\Cabinet\Repository\ProfileRepository;
use App\Utils\Flusher;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler
{
    public function __construct(
        private ProfileRepository $repository,
        private Flusher $flusher
    )
    {
    }

    public function handle(Command $command): void
    {
        $profile = $this->repository->getProfileByUserId($command->userId);
        if ($profile === null) {
            throw new NotFoundHttpException('профиль пользователя не найден');
        }
        $profile->setEmail($command->newEmail);
        $this->flusher->flush();
    }
}