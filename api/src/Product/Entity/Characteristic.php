<?php

namespace App\Product\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Characteristic
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'uuid')]
        private Id $id,
        #[ORM\Column(type: 'string', length: 255)]
        private string $name,
        #[ORM\ManyToOne(
            targetEntity: UnitOfMeasurement::class,
            cascade: ['persist'],
        )]
        private UnitOfMeasurement $unitOfMeasurement,
    )
    {
    }
}