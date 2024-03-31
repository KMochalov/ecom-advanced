<?php

declare(strict_types=1);

namespace App\Auth\Command\AttachNetwork;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{

    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid]
        public string $id,
        #[Assert\NotBlank]
        public string $network,
        #[Assert\NotBlank]
        public string $identity,
    ) {
    }
}
