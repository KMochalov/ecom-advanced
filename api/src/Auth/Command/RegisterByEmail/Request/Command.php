<?php

declare(strict_types=1);

namespace App\Auth\Command\RegisterByEmail\Request;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Email]
        public string $email,
        #[Assert\NotBlank]
        #[Assert\Length(min: 5)]
        public string $password
    ) {
    }
}
