<?php

namespace App\Entity;

use App\Repository\ProductCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[
    ORM\Entity(repositoryClass: ProductCategoryRepository::class),
    ORM\Table(name: 'product_categories')
]
class ProductCategory
{
    #[
        ORM\Id,
        ORM\GeneratedValue,
        ORM\Column
    ]
    private ?int $id = null;

    #[ORM\Column(name: 'name', length: 255)]
    private ?string $name = null;

	#[ORM\Column(name: 'summary', type: Types::TEXT)]
	private ?string $summary = null;

	#[ORM\Column(name: 'description', type: Types::TEXT)]
	private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
    private ?self $parent = null;

    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parent', cascade: ['remove'])]
    private Collection $children;

    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'category')]
    private Collection $equipments;

	#[
		ORM\ManyToOne(targetEntity: Technology::class),
		ORM\JoinColumn(referencedColumnName: 'id')
	]
	private ?Technology $technology = null;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->equipments = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): static
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): static
    {
        if ($this->children->removeElement($child)) {
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    public function addEquipment(Product $product): static
    {
        if (!$this->equipments->contains($product)) {
            $this->equipments->add($product);
        }
        return $this;
    }

    public function removeEquipment(Product $product): static
    {
        $this->equipments->removeElement($product);

        return $this;
    }

	public function getSummary(): ?string
	{
		return $this->summary;
	}

	public function setSummary(?string $summary): void
	{
		$this->summary = $summary;
	}

	public function getDescription(): ?string
	{
		return $this->description;
	}

	public function setDescription(?string $description): void
	{
		$this->description = $description;
	}

	public function getEquipments(): Collection
	{
		return $this->equipments;
	}

	public function getTechnology(): ?Technology
	{
		return $this->technology;
	}

	public function setTechnology(?Technology $technology): void
	{
		$this->technology = $technology;
	}
}
