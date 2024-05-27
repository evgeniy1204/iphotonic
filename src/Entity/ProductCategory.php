<?php

namespace App\Entity;

use App\Repository\ProductCategoryRepository;
use App\Service\Breadcrumb\BreadcrumbAwareInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[
    ORM\Entity(repositoryClass: ProductCategoryRepository::class),
    ORM\Table(name: 'product_categories'),
	UniqueEntity(fields: ['slug'], message: 'This field should be unique', errorPath: 'slug')
]
class ProductCategory implements BreadcrumbAwareInterface
{
	public const PRODUCT_CATEGORY_PREVIEW_FOLDER = 'product_category';

	#[
        ORM\Id,
        ORM\GeneratedValue,
        ORM\Column(name: 'id')
    ]
    private int $id;

    #[ORM\Column(name: 'name', type: Types::STRING, length: 255, nullable: true)]
    private ?string $name;

	#[ORM\Column(name: 'summary', type: Types::TEXT, nullable: true)]
	private ?string $summary;

	#[ORM\Column(name: 'description', type: Types::TEXT, nullable: true)]
	private ?string $description;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
    private ?self $parent;

	#[ORM\Column(name: 'preview_image', length: 255, nullable: true)]
	private ?string $previewImage;

    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parent', cascade: ['remove'])]
    private Collection $children;

	#[ORM\Column(name: 'slug', type: Types::STRING, length: 255, unique: true, nullable: true)]
	private ?string $slug;

	#[ORM\ManyToMany(targetEntity: Product::class)]
    private Collection $equipments;

	#[
		ORM\ManyToOne(targetEntity: Technology::class),
		ORM\JoinColumn(referencedColumnName: 'id')
	]
	private ?Technology $technology;

    public function __construct()
    {
		$this->id = 0;
		$this->name = null;
		$this->slug = null;
		$this->description = null;
		$this->parent = null;
		$this->previewImage = null;
        $this->children = new ArrayCollection();
        $this->equipments = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name ?? '';
    }

    public function getId(): int
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

	/**
	 * @return ProductCategory[]
	 */
    public function getChildren(): array
    {
        return $this->children->toArray();
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

	public function getEquipments(): array
	{
		return $this->equipments->toArray();
	}

	public function getTechnology(): ?Technology
	{
		return $this->technology;
	}

	public function setTechnology(?Technology $technology): void
	{
		$this->technology = $technology;
	}

	public function getSlug(): ?string
	{
		return $this->slug;
	}

	public function setSlug(?string $slug): void
	{
		$this->slug = $slug;
	}

	/**
	 * @return ProductCategory[]
	 */
	public function getFinalCategories(): array
	{
		$finalCategories = [];
		$this->findFinalCategory($finalCategories);

		return $finalCategories;
	}

	private function findFinalCategory(array &$finalCategories): void
	{
		foreach ($this->getChildren() as $child) {
			if ($child->getChildren()) {
				$child->findFinalCategory($finalCategories);
			}
			$finalCategories[] = $child;
		}
	}

	public function getPreviewImage(): ?string
	{
		return $this->previewImage;
	}

	public function setPreviewImage(?string $previewImage): void
	{
		$this->previewImage = $previewImage;
	}
}
