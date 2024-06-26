<?php

namespace App\Entity;

use App\Enum\SearchResultTypeEnum;
use App\Repository\TechnologyRepository;
use App\Service\Breadcrumb\BreadcrumbAwareInterface;
use App\Service\Search\SearchResultAwareInterface;
use App\Trait\SeoFieldsTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[
    ORM\Entity(repositoryClass: TechnologyRepository::class),
    ORM\Table(name: 'technologies')
]
class Technology implements SearchResultAwareInterface, BreadcrumbAwareInterface
{
	use SeoFieldsTrait;

	public const TECHNOLOGY_IMAGES_FOLDER = 'technology';

    #[
        ORM\Id,
        ORM\GeneratedValue,
        ORM\Column(name: 'id')
    ]
    private int $id;

    #[ORM\Column(name: 'content', type: Types::TEXT, nullable: true)]
    private ?string $content;

	#[ORM\Column(name: 'summary', type: Types::TEXT, nullable: true)]
	private ?string $summary;

	#[ORM\Column(name: 'image', type: Types::STRING, nullable: true)]
	private ?string $image;

	#[ORM\Column(name: 'image_short_description', type: Types::STRING, nullable: true)]
	private ?string $imageShortDescription;

	#[
		ORM\ManyToOne(targetEntity: Technology::class, inversedBy: 'children'),
		ORM\JoinColumn(referencedColumnName: 'id')
	]
	private ?Technology $parent;

	#[ORM\OneToMany(targetEntity: Technology::class, mappedBy: 'parent', cascade: ['remove'])]
	private Collection $children;

    #[ORM\Column(name: 'name', type: Types::STRING, length: 255, nullable: true)]
    private ?string $name;

	#[ORM\Column(name: 'slug', type: Types::STRING, length: 255, unique: true)]
	private ?string $slug;

	#[ORM\Column(name: 'is_active', type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
	private bool $active;

	#[ORM\Column(name: 'menu_order', type: Types::INTEGER, nullable: false)]
	private int $menuOrder;

    public function __construct()
    {
		$this->id = 0;
		$this->name = null;
		$this->slug = null;
		$this->active = false;
		$this->parent = null;
		$this->summary = null;
		$this->image = null;
		$this->menuOrder = 0;
		$this->imageShortDescription = null;
		$this->children = new ArrayCollection();
    }

    public function __toString():string
    {
        return $this->name ?? '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

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

	public function getSlug(): ?string
	{
		return $this->slug;
	}

	public function setSlug(?string $slug): void
	{
		$this->slug = $slug;
	}

	public function getParent(): ?Technology
	{
		return $this->parent;
	}

	public function setParent(?Technology $parent): void
	{
		$this->parent = $parent;
	}

	/**
	 * @return Collection|Technology[]
	 */
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

	public function getSearchResultType(): SearchResultTypeEnum
	{
		return SearchResultTypeEnum::TYPE_TECHNOLOGY;
	}

	public function getSearchResultTitle(): string
	{
		return $this->name;
	}

	public function getSearchedResultShortText(): string
	{
		return $this->summary ?? '';
	}

	public function getActive(): bool
	{
		return $this->active;
	}

	public function setActive(?bool $active): void
	{
		$this->active = (bool) $active;
	}

	public function getSummary(): ?string
	{
		return $this->summary;
	}

	public function setSummary(?string $summary): void
	{
		$this->summary = $summary;
	}

	public function getImage(): ?string
	{
		return $this->image;
	}

	public function setImage(?string $image): void
	{
		$this->image = $image;
	}

	public function getImageShortDescription(): ?string
	{
		return $this->imageShortDescription;
	}

	public function setImageShortDescription(?string $imageShortDescription): void
	{
		$this->imageShortDescription = $imageShortDescription;
	}

	public function getMenuOrder(): int
	{
		return $this->menuOrder;
	}

	public function setMenuOrder(int $menuOrder): void
	{
		$this->menuOrder = $menuOrder;
	}
}
