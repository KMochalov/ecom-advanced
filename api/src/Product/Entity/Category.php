<?php

namespace App\Product\Entity;

use App\Entity\Id;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'categories')]
class Category
{

    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'category', cascade: ['persist'])]
    private Collection $products;
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parent')]
    private Collection $children;

    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'uuid', unique: true)]
        private Id $id,
        #[ORM\Column(type: 'string', length: 255, nullable: false)]
        private string $name,
        #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
        #[ORM\JoinColumn(name: 'parent_id', referencedColumnName: 'id')]
        private ?Category $parent
    )
    {
        $this->products = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
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

    public function setParent(?Category $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }
}