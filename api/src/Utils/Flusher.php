<?php

namespace App\Utils;

use Doctrine\ORM\EntityManagerInterface;

class Flusher
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }
}