<?php

namespace App\Product\Entity;

use App\Entity\Id;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class ProductVariant
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'uuid')]
        private Id $id,
        #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'variants')]
        private Product $product,
        #[ORM\Column(type: 'string', length: 255)]
        private string $name,
        #[ORM\OneToMany(
            targetEntity: CharacteristicValue::class,
            mappedBy: 'variant',
            cascade: ['persist', 'remove'],
            orphanRemoval: true
        )]
        /* @var $characteristicsValue Collection<int, CharacteristicValue> */
        private Collection $characteristicsValue
    )
    {
        $this->characteristicsValue = new ArrayCollection();
    }
}