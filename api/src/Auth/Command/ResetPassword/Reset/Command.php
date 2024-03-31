<?php

declare(strict_types=1);

namespace App\Auth\Command\ResetPassword\Reset;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    public function __construct(
        #[Assert\NotBlank]
        public string $token,
        #[Assert\NotBlank]
        #[Assert\Length(min: 5)]
        public string $password
    ) {
    }
}
