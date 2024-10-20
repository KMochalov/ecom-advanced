<?php

namespace App\Product\Entity;

use App\Entity\Id;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'products')]
class Product
{
    #[ORM\ManyToOne(targetEntity: Category::class, cascade: ['persist'], inversedBy: 'products')]
    #[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id', nullable: true)]
    private Category $category;

    #[ORM\OneToMany(
        targetEntity: ProductCharacteristic::class,
        mappedBy: 'product',
        cascade: ['persist', 'remove'],
        orphanRemoval: true
    )]
    /**
     * @var $productCharacteristics Collection<int, ProductCharacteristic>
     */
    private Collection $productCharacteristics;

    #[ORM\OneToMany(targetEntity: ProductVariant::class, mappedBy: 'product', cascade: ['persist', 'remove'], orphanRemoval: true)]
    /**
     * @var $variants Collection<int, ProductVariant>
     */
    private Collection $variants;

    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'uuid', unique: true)]
        private Id $id,
        #[ORM\Column(type: 'string', length: 255, nullable: false)]
        private string $name
    )
    {
        $this->productCharacteristics = new ArrayCollection();
        $this->variants = new ArrayCollection();
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}