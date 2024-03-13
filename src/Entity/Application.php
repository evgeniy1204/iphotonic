<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[
    ORM\Entity(repositoryClass: ApplicationRepository::class),
    ORM\Table(name: 'applications')
]
class Application
{
	public const APPLICATION_IMAGES_BASE_PATH = '/uploads/images/application/images/';

    #[
        ORM\Id,
        ORM\GeneratedValue,
        ORM\Column
    ]
    private ?int $id = null;

    #[ORM\Column(name: 'text', type: Types::TEXT, nullable: true)]
    private ?string $text = null;

    #[ORM\ManyToOne(targetEntity: ApplicationCategory::class, inversedBy: 'applications')]
    private ?ApplicationCategory $category = null;

    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'applications')]
    private Collection $products;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

	#[ORM\Column(name: 'images', type: Types::SIMPLE_ARRAY)]
	private array $images;

    public function __construct()
    {
        $this->products = new ArrayCollection();
		$this->images = [];
    }

    public function __toString(): string
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

    public function getCategory(): ?ApplicationCategory
    {
        return $this->category;
    }

    public function setCategory(?ApplicationCategory $category): static
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
            $product->addApplication($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            $product->removeApplication($this);
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

	public function setImages(array $images): void
	{
		$this->images = $images;
	}
}
