<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: 'products')]
class Product
{
    #[
        ORM\GeneratedValue,
        ORM\Column,
        ORM\Id
    ]
    private ?int $id = null;

    #[ORM\Column(name: 'text', type: Types::TEXT, nullable: true)]
    private ?string $text = null;

    #[ORM\ManyToMany(targetEntity: Technology::class, inversedBy: 'products')]
    private Collection $technologies;

    #[ORM\ManyToMany(targetEntity: Application::class, inversedBy: 'products')]
    private Collection $applications;

    #[ORM\ManyToMany(targetEntity: ProductCategory::class, inversedBy: 'products')]
    private Collection $categories;

    public function __construct()
    {
        $this->technologies = new ArrayCollection();
        $this->applications = new ArrayCollection();
        $this->categories = new ArrayCollection();
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

    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(ProductCategory $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(ProductCategory $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }
}
