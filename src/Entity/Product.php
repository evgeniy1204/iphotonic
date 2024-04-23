<?php

namespace App\Entity;

use App\Constants;
use App\Enum\SearchResultTypeEnum;
use App\Repository\ProductRepository;
use App\SeoFieldsTrait;
use App\Service\SearchResultAwareInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[
    ORM\Entity(repositoryClass: ProductRepository::class),
    ORM\Table(name: 'products'),
	UniqueEntity(fields: ['slug'], message: 'This field should be unique', errorPath: 'slug')
]
class Product implements SearchResultAwareInterface
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

    #[
		ORM\ManyToOne(targetEntity: Technology::class),
		ORM\JoinColumn(referencedColumnName: 'id')
	]
    private ?Technology $technology;

	#[
		ORM\ManyToMany(targetEntity: Product::class)
	]
	private Collection $relationProducts;

    #[ORM\Column(name: 'images', type: Types::SIMPLE_ARRAY, nullable: true)]
    private ?array $images;

    #[ORM\Column(name: 'files', type: Types::SIMPLE_ARRAY, nullable: true)]
    private ?array $files;

    #[ORM\ManyToOne(targetEntity: ProductCategory::class, inversedBy: 'products')]
    private ?ProductCategory $category = null;

    #[ORM\Column(name: 'name', length: 255)]
    private ?string $name = null;

    #[ORM\Column(name: 'slug', length: 255, unique: true)]
    private ?string $slug = null;

    #[ORM\Column(name: 'is_active', options: ['default' => false])]
    private ?bool $active = null;


    public function __construct()
    {
        $this->seo = new SeoEmbed();
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

    public function getSearchResultType(): SearchResultTypeEnum
    {
        return SearchResultTypeEnum::TYPE_PRODUCT;
    }

    public function getSearchResultTitle(): string
    {
        return $this->name;
    }

    public function getSearchResultSlug(): string
    {
        return $this->name;
    }

    public function getSearchedResultShortText(): string
    {
        return $this->text;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

	public function getTechnology(): ?Technology
	{
		return $this->technology;
	}

	public function setTechnology(?Technology $technology): void
	{
		$this->technology = $technology;
	}

	/**
	 * @return Collection|Product[]
	 */
	public function getRelationProducts(): Collection
	{
		return $this->relationProducts;
	}

	public function setRelationProducts(Collection $relationProducts): void
	{
		$this->relationProducts = $relationProducts;
	}

	public function getFilePaths(): array
	{
		$filePaths = [];
		foreach ($this->files as $file) {
			$filePaths[] = [
				'name' => $file,
				'path' => sprintf('/%s%s/%s', Constants::ADMIN_ROOT_READ_IMAGES_DIR, self::PRODUCT_FILES_FOLDER, $file)
			];
		}

		return $filePaths;
	}
}
