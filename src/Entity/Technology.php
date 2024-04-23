<?php

namespace App\Entity;

use App\Enum\SearchResultTypeEnum;
use App\Repository\TechnologyRepository;
use App\SeoFieldsTrait;
use App\Service\SearchResultAwareInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[
    ORM\Entity(repositoryClass: TechnologyRepository::class),
    ORM\Table(name: 'technologies')
]
class Technology implements SearchResultAwareInterface
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

	#[ORM\Column(name: 'images', type: Types::SIMPLE_ARRAY, nullable: true)]
	private ?array $images = null;

	#[
		ORM\ManyToOne(targetEntity: Technology::class, inversedBy: 'children'),
		ORM\JoinColumn(referencedColumnName: 'id')
	]
	private ?Technology $parent;

	#[ORM\OneToMany(targetEntity: Technology::class, mappedBy: 'parent', cascade: ['remove'])]
	private Collection $children;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

	#[ORM\Column(name: 'slug', length: 255, unique: true)]
	private ?string $slug = null;

	#[ORM\Column(name: 'is_active', options: ['default' => false])]
	private ?bool $active = null;

    public function __construct()
    {
		$this->children = new ArrayCollection();
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
		return $this->name;
	}

	public function getSearchResultSlug(): string
	{
		return $this->slug;
	}

	public function getActive(): ?bool
	{
		return $this->active;
	}

	public function setActive(?bool $active): void
	{
		$this->active = $active;
	}
}
