<?php

namespace App\Entity;

use App\Constants;
use App\Repository\ApplicationRepository;
use App\Trait\SeoFieldsTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[
    ORM\Entity(repositoryClass: ApplicationRepository::class),
    ORM\Table(name: 'applications')
]
class Application
{
	use SeoFieldsTrait;

	public const APPLICATION_IMAGE_FOLDER= 'application';

    #[
        ORM\Id,
        ORM\GeneratedValue,
        ORM\Column(name: 'id')
    ]
    private int $id;

    #[ORM\Column(name: 'text', type: Types::TEXT, nullable: true)]
    private ?string $text;

    #[ORM\Column(name: 'name', type: Types::STRING, length: 255, nullable: true)]
    private ?string $name;

	#[ORM\Column(name: 'preview', type: Types::STRING, length: 255, nullable: true)]
	private ?string $preview;

	public function __construct()
	{
		$this->id = 0;
		$this->text = null;
		$this->name = null;
		$this->preview = null;
	}

	public function __toString(): string
    {
        return $this->name ?? '';
    }

    public function getId(): int
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

	public function getPreview(): ?string
	{
		return $this->preview;
	}

	public function setPreview(?string $preview): void
	{
		$this->preview = $preview;
	}
}
