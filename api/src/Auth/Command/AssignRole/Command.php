<?php

declare(strict_types=1);

namespace App\Auth\Command\AssignRole;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid]
        public string $userId,
        #[Assert\NotBlank]
        public string $role
    ) {
    }
}
