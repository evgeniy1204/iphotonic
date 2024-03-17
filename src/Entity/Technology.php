<?php

namespace App\Entity;

use App\Repository\TechnologyRepository;
use App\SeoFieldsTrait;
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
	use SeoFieldsTrait;

	public const TECHNOLOGY_IMAGES_FOLDER = 'technology';

    #[
        ORM\Id,
        ORM\GeneratedValue,
        ORM\Column
    ]
    private ?int $id = null;

    #[ORM\Column(name: 'text', type: Types::TEXT, nullable: true)]
    private ?string $text = null;

    #[ORM\ManyToOne(targetEntity: TechnologyCategory::class, inversedBy: 'technologies')]
    private ?TechnologyCategory $category = null;

    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'technologies')]
    private Collection $products;

	#[ORM\Column(name: 'images', type: Types::SIMPLE_ARRAY, nullable: true)]
	private ?array $images = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function __toString():string
    {
        return $this->name;
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

    public function getCategory(): ?TechnologyCategory
    {
        return $this->category;
    }

    public function setCategory(?TechnologyCategory $category): static
    {
        $this->category = $category;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

	public function getImages(): array
	{
		return $this->images;
	}

	public function setImages(?array $images): void
	{
		$this->images = $images;
	}
}
