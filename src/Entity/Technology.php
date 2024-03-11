<?php

namespace App\Entity;

use App\Repository\TechnologyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[
    ORM\Entity(repositoryClass: TechnologyRepository::class),
    ORM\Table(name: 'technologies')
]
class Technology
{
    #[
        ORM\Id,
        ORM\GeneratedValue,
        ORM\Column
    ]
    private ?int $id = null;

    #[ORM\Column(name: 'text', type: Types::TEXT, nullable: true)]
    private ?string $text = null;

    #[ORM\ManyToMany(targetEntity: TechnologyCategory::class, inversedBy: 'technologies')]
    private Collection $categories;

    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'technologies')]
    private Collection $products;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    public function __toString():string
    {
        return $this->text;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(TechnologyCategory $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(TechnologyCategory $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->addTechnology($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            $product->removeTechnology($this);
        }

        return $this;
    }
}
