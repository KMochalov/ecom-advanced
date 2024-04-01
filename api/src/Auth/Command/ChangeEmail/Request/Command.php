<?php

declare(strict_types=1);

namespace App\Auth\Command\ChangeEmail\Request;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Ulid]
        public string $userId,
        #[Assert\NotBlank]
        #[Assert\Email]
        public string $newEmail
    ) {
    }
}
