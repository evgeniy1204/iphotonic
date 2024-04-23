<?php

namespace App\Entity;

use App\Repository\PossibilitiesRepository;
use App\SeoFieldsTrait;
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

	#[ORM\Column(name: 'description', length: 255)]
	private ?string $description = null;

	public function __construct()
	{
		$this->seo = new SeoEmbed();
	}

    public function getId(): ?int
    {
        return $this->id;
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
}
