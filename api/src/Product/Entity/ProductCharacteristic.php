<?php

namespace App\Product\Entity;

use App\Entity\Id;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
class ProductCharacteristic
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'uuid')]
        private Id $id,
        #[ORM\ManyToOne(
            targetEntity: Product::class,
            cascade: ['persist', 'remove'],
        )]
        private Product $product,
        #[ORM\ManyToOne(
            targetEntity: Characteristic::class,
            cascade: ['persist', 'remove'],
        )]
        private Characteristic $characteristic
    )
    {
    }
}