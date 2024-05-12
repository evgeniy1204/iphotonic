<?php

namespace App\Entity;

use App\Repository\PossibilitiesRepository;
use App\Trait\SeoFieldsTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PossibilitiesRepository::class)]
class Possibilities
{
	use SeoFieldsTrait;

	#[
		ORM\Id,
		ORM\GeneratedValue,
		ORM\Column(name: 'id')
	]
	private int $id;

	#[ORM\Column(name: 'content', type: Types::TEXT, nullable: true)]
	private ?string $content;

	public function __construct()
	{
		$this->id = 0;
		$this->content = null;
		$this->seo = new SeoEmbed();
	}

    public function getId(): int
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
}
