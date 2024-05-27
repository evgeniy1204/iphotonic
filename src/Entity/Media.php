<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use App\Service\Breadcrumb\BreadcrumbAwareInterface;
use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
class Media implements BreadcrumbAwareInterface
{
	public const PREVIEW_IMAGE_FOLDER = 'media_preview';

	#[
		ORM\Id,
		ORM\GeneratedValue,
		ORM\Column(name: 'id')
	]
    private int $id;

    #[ORM\Column(name: 'title', type: Types::STRING, length: 255, nullable: true)]
    private ?string $title;

    #[ORM\Column(name: 'preview', type: Types::STRING, length: 255, nullable: true)]
    private ?string $preview;

	#[ORM\Column(name: 'slug', type: Types::STRING, length: 255, nullable: true)]
	private ?string $slug;

    #[ORM\Column(name: 'description', type: Types::TEXT, nullable: true)]
    private ?string $description;

	#[ORM\Column(name: 'active', type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
	private bool $active;

	#[ORM\Column(name: 'created_at', type: Types::DATETIME_MUTABLE, nullable: true, options: ['default' => 'CURRENT_TIMESTAMP'])]
	private ?DateTimeInterface $createdAt;

	public function __construct()
	{
		$this->id = 0;
		$this->title = null;
		$this->preview = null;
		$this->description = null;
		$this->slug = null;
		$this->active = false;
		$this->createdAt = new DateTime();
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

    public function getPreview(): ?string
    {
        return $this->preview;
    }

    public function setPreview(string $preview): static
    {
        $this->preview = $preview;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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

	public function isActive(): bool
	{
		return $this->active;
	}

	public function setActive(bool $active): void
	{
		$this->active = $active;
	}

	public function getCreatedAt(): DateTime
	{
		return $this->createdAt;
	}

	public function setCreatedAt(?DateTimeInterface $createdAt): void
	{
		$this->createdAt = $createdAt;
	}
}
