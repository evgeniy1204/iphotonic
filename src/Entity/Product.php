<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use App\SeoFieldsTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[
    ORM\Entity(repositoryClass: ProductRepository::class),
    ORM\Table(name: 'products')
]
class Product
{
	use SeoFieldsTrait;

	public const PRODUCT_FILES_FOLDER = 'product';

	#[
        ORM\GeneratedValue,
        ORM\Column,
        ORM\Id
    ]
    private ?int $id = null;

    #[ORM\Column(name: 'text', type: Types::TEXT, nullable: true)]
    private ?string $text = null;

	#[ORM\Column(name: 'summary', type: Types::TEXT, nullable: true)]
	private ?string $summary = null;

    #[ORM\ManyToMany(targetEntity: Technology::class, inversedBy: 'products')]
    private Collection $technologies;

    #[ORM\ManyToMany(targetEntity: Application::class, inversedBy: 'products')]
    private Collection $applications;

	#[ORM\Column(name: 'images', type: Types::SIMPLE_ARRAY, nullable: true)]
	private ?array $images;

	#[ORM\Column(name: 'files', type: Types::SIMPLE_ARRAY, nullable: true)]
	private ?array $files;

    #[ORM\ManyToOne(targetEntity: ProductCategory::class, inversedBy: 'products')]
    private ?ProductCategory $category = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;



    public function __construct()
    {
        $this->technologies = new ArrayCollection();
        $this->applications = new ArrayCollection();
		$this->seo = new SeoEmbed();
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

    public function getTechnologies(): Collection
    {
        return $this->technologies;
    }

    public function addTechnology(Technology $technology): static
    {
        if (!$this->technologies->contains($technology)) {
            $this->technologies->add($technology);
        }

        return $this;
    }

    public function removeTechnology(Technology $technology): static
    {
        $this->technologies->removeElement($technology);

        return $this;
    }

    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): static
    {
        if (!$this->applications->contains($application)) {
            $this->applications->add($application);
        }

        return $this;
    }

    public function removeApplication(Application $application): static
    {
        $this->applications->removeElement($application);

        return $this;
    }

    public function getCategory(): ?ProductCategory
    {
        return $this->category;
    }

    public function setCategory(?ProductCategory $category): static
    {
        $this->category = $category;

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

	public function getSummary(): ?string
	{
		return $this->summary;
	}

	public function setSummary(?string $summary): void
	{
		$this->summary = $summary;
	}

	public function getFiles(): ?array
	{
		return $this->files;
	}

	public function setFiles(?array $files): void
	{
		$this->files = $files;
	}
}
