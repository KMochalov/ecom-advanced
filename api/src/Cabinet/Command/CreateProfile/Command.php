<?php

namespace App\Cabinet\Command\CreateProfile;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Ulid]
        public string $userId,
        #[Assert\NotBlank]
        #[Assert\Email]
        public string $email,
    ) {
    }
}
