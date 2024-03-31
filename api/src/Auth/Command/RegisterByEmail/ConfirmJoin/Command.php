<?php

namespace App\Auth\Command\RegisterByEmail\ConfirmJoin;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    public function __construct(
        #[Assert\NotBlank]
        public string $token
    ) {
    }
}
