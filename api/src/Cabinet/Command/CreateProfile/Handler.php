<?php

namespace App\Cabinet\Command\CreateProfile;

use App\Auth\Repository\UserRepositoryInterface;
use App\Auth\Services\HasherInterface;
use App\Auth\Services\SenderInterface;
use App\Auth\Services\TokenizerInterface;
use App\Cabinet\Entity\Profile;
use App\Cabinet\Repository\ProfileRepository;
use App\Entity\Email;
use App\Entity\Id;
use App\Utils\Flusher;
use DomainException;

class Handler
{
    public function __construct(
        private ProfileRepository $repository,
        private Flusher $flusher,
    )
    {}

    public function handle(Command $command): void
    {
        $userId = new Id($command->userId);
        $email = new Email($command->email);
        if ($this->repository->existByUserId($userId)) {
            throw new DomainException('Профиль этого пользователя уже существует');
        }

        $profile = new Profile(
            Id::generate(),
            $userId,
            $email
        );

        $this->repository->add($profile);
        $this->flusher->flush();
    }
}
