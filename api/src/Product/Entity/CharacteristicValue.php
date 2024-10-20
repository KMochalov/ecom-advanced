<?php

namespace App\Product\Entity;

use App\Entity\Id;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class CharacteristicValue
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'uuid')]
        private Id $id,
        #[ORM\ManyToOne(targetEntity: ProductVariant::class, cascade: ['persist'], inversedBy: 'characteristicsValue')]
        private ProductVariant $variant,
        #[ORM\ManyToOne(targetEntity: Characteristic::class, cascade: ['persist'])]
        private Characteristic $characteristic,
        private string $value
    )
    {
    }
}