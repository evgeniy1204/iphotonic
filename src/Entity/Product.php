<?php

namespace App\Entity;

use App\Constants;
use App\Enum\SearchResultTypeEnum;
use App\Repository\ProductRepository;
use App\Service\Breadcrumb\BreadcrumbAwareInterface;
use App\Service\Search\SearchResultAwareInterface;
use App\Trait\SeoFieldsTrait;
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
class Product implements SearchResultAwareInterface, BreadcrumbAwareInterface
{
    use SeoFieldsTrait;

    public const PRODUCT_FILES_FOLDER = 'product';

    #[
		ORM\Id,
		ORM\GeneratedValue,
		ORM\Column(name: 'id'),
    ]
    private int $id;

    #[ORM\Column(name: 'text', type: Types::TEXT, nullable: true)]
    private ?string $text;

    #[ORM\Column(name: 'summary', type: Types::TEXT, nullable: true)]
    private ?string $summary;

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
    private array $images;

    #[ORM\Column(name: 'files', type: Types::SIMPLE_ARRAY, nullable: true)]
    private array $files;

    #[
		ORM\ManyToOne(targetEntity: ProductCategory::class),
		ORM\JoinColumn(referencedColumnName: 'id', onDelete: 'SET NULL')
	]
    private ?ProductCategory $category;

    #[ORM\Column(name: 'name', type: Types::STRING , length: 255, nullable: true)]
    private ?string $name;

    #[ORM\Column(name: 'slug', type: Types::STRING, length: 255, unique: true, nullable: true)]
    private ?string $slug;

    #[ORM\Column(name: 'is_active', nullable: false, options: ['default' => false])]
    private bool $active;

	#[ORM\Column(name: 'show_on_main_page', nullable: false, options: ['default' => false])]
	private bool $showOnMainPage;

	#[ORM\Column(name: 'menu_order', type: Types::INTEGER, nullable: false)]
	private int $menuOrder;

    public function __construct()
    {
		$this->id = 0;
		$this->name = null;
		$this->summary = null;
		$this->text = null;
		$this->slug = null;
		$this->active = false;
		$this->showOnMainPage = false;
		$this->files = [];
		$this->images = [];
		$this->category = null;
		$this->technology = null;
		$this->menuOrder = 0;
		$this->relationProducts = new ArrayCollection();
        $this->seo = new SeoEmbed();
    }

    public function __toString(): string
    {
        return $this->name ?? '';
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

    public function getImages(): ?array
    {
        return $this->images;
    }

    public function setImages(?array $images): void
    {
		$resultSet = [];
		foreach ($images as $image) {
			if ($image) {
				$resultSet[] = $image;
			}
		}
        $this->images = $resultSet;
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
		$resultSet = [];
		foreach ($files as $file) {
			if ($file) {
				$resultSet[] = $file;
			}
		}
        $this->files = $resultSet;
    }

    public function getSearchResultType(): SearchResultTypeEnum
    {
        return SearchResultTypeEnum::TYPE_PRODUCT;
    }

    public function getSearchResultTitle(): string
    {
        return $this->name ?? '';
    }

    public function getSearchedResultShortText(): string
    {
        return $this->summary ?? '';
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
	 * eturn Product[]
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
				'path' => sprintf('%s%s/%s', Constants::ADMIN_ROOT_READ_IMAGES_DIR, self::PRODUCT_FILES_FOLDER, $file)
			];
		}

		return $filePaths;
	}

	public function isShowOnMainPage(): bool
	{
		return $this->showOnMainPage;
	}

	public function setShowOnMainPage(bool $showOnMainPage): void
	{
		$this->showOnMainPage = $showOnMainPage;
	}

	/**
	 * @return string[]
	 */
	public function buildBreadcrumbs(): array
	{
		$breadcrumbs = [];
		$breadcrumbs[] = $this->getName();

		$this->generateBreadcrumbs($breadcrumbs, $this->getCategory());

		return array_reverse($breadcrumbs);
	}

	private function generateBreadcrumbs(array &$breadcrumbs, ProductCategory $category): void
	{
		$breadcrumbs[] = $category->getName();
		if ($category->getParent()) {
			$this->generateBreadcrumbs($breadcrumbs, $category->getParent());
		}
	}

	public function getMenuOrder(): int
	{
		return $this->menuOrder;
	}

	public function setMenuOrder(int $menuOrder): void
	{
		$this->menuOrder = $menuOrder;
	}

	public function getPreviewImagePath(): string
	{
		return sprintf('%s%s/%s', Constants::ADMIN_ROOT_READ_IMAGES_DIR, self::PRODUCT_FILES_FOLDER, $this->getImages()[0] ?? '');
	}
}
