<?php

namespace App\Auth\Command\ChangeEmail\Confirm;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    public function __construct(
        #[Assert\NotBlank]
        public string $token
    ) {
    }
}
