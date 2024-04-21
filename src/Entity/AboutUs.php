<?php

namespace App\Entity;

use App\Repository\AboutUsRepository;
use App\SeoFieldsTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AboutUsRepository::class)]
class AboutUs
{
	use SeoFieldsTrait;

	public const ID_OF_SINGLE_ENTITY = 1;

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

	public function getId(): int
    {
        return self::ID_OF_SINGLE_ENTITY;
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
