<?php

namespace App\Entity;

use App\Enum\SearchResultTypeEnum;
use App\Repository\EventRepository;
use App\Service\Breadcrumb\BreadcrumbAwareInterface;
use App\Service\Search\SearchResultAwareInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[
    ORM\Entity(repositoryClass: EventRepository::class),
    ORM\Table(name: 'events'),
]
class Event implements SearchResultAwareInterface, BreadcrumbAwareInterface
{
    public const PREVIEW_IMAGE_FOLDER = 'event_preview';

    #[
        ORM\Id,
        ORM\GeneratedValue,
        ORM\Column(name: 'id')
    ]
    private int $id;

    #[ORM\Column(name: 'title', type: Types::STRING, length: 255, nullable: true)]
    private ?string $title;

    #[ORM\Column(name: 'summary', type: Types::TEXT, nullable: true)]
    private ?string $summary;

    #[ORM\Column(name: 'created_event_start_at', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdEventStartAt;

    #[ORM\Column(name: 'created_event_end_at', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdEventEndAt;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_MUTABLE, nullable: true, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $createdAt;

    #[ORM\Column(name: 'text', type: Types::TEXT, nullable: true)]
    private ?string $text;

    #[ORM\Column(name: 'preview', type: Types::STRING, length: 255, nullable: true)]
    private ?string $preview;

    #[ORM\Column(name: 'is_active', type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    private bool $active;

    #[ORM\Column(name: 'slug', type: Types::STRING, length: 255, nullable: true)]
    private ?string $slug;

    public function __construct()
    {
		$this->id = 0;
		$this->title = null;
		$this->summary = null;
		$this->createdEventStartAt = null;
		$this->createdEventEndAt = null;
		$this->text = null;
		$this->preview = null;
		$this->slug = null;
        $this->createdAt = new \DateTime();
        $this->active = false;
    }

	public function __toString(): string
	{
		return $this->title ?? '';
	}

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatedEventStartAt(): ?\DateTimeInterface
    {
        return $this->createdEventStartAt;
    }

    public function setCreatedEventStartAt(\DateTimeInterface $createdEventStartAt): static
    {
        $this->createdEventStartAt = $createdEventStartAt;

        return $this;
    }

    public function getCreatedEventEndAt(): ?\DateTimeInterface
    {
        return $this->createdEventEndAt;
    }

    public function setCreatedEventEndAt(\DateTimeInterface $createdEventEndAt): static
    {
        $this->createdEventEndAt = $createdEventEndAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $dateTime): void
    {
        $this->createdAt = $dateTime;
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

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function getPreview(): ?string
    {
        return $this->preview;
    }

    public function setPreview(?string $preview): void
    {
        $this->preview = $preview;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): void
    {
        $this->summary = $summary;
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

	public function getSearchResultType(): SearchResultTypeEnum
	{
		return SearchResultTypeEnum::TYPE_EVENT;
	}

	public function getSearchResultTitle(): string
	{
		return $this->title ?? '';
	}

	public function getSearchedResultShortText(): string
	{
		return $this->summary ?? '';
	}
}
