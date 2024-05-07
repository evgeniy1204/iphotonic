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

	#[ORM\Column(name: 'description', type: Types::TEXT, nullable: true)]
	private ?string $description;

	public function __construct()
	{
		$this->id = 0;
		$this->description = null;
		$this->seo = new SeoEmbed();
	}

    public function getId(): int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
