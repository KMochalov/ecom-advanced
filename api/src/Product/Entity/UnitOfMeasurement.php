<?php

namespace App\Product\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class UnitOfMeasurement
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'uuid')]
        private Id $id,
        #[ORM\Column(type: 'string', length: 36)]
        private string $name,
        #[ORM\Column(type: 'string', length: 36)]
        private string $shortName,
        #[ORM\Column(type: 'string', length: 36)]
        private string $type,
    )
    {
    }
}