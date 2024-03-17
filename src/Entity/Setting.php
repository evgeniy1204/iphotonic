<?php

namespace App\Entity;

use App\Repository\SettingRepository;
use App\SeoFieldsTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[
	ORM\Entity(repositoryClass: SettingRepository::class),
	ORM\Table(name: 'settings')
]
class Setting
{
	public const SLIDER_IMAGES_FOLDER = 'slider';

	use SeoFieldsTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'linked_in', length: 255, nullable: true)]
    private ?string $linkedIn = null;

    #[ORM\Column(name: 'youtube', length: 255, nullable: true)]
    private ?string $youtube = null;

    #[ORM\Column(name: 'instagram', length: 255, nullable: true)]
    private ?string $instagram = null;

	#[ORM\Column(name: 'slider_images', type: Types::SIMPLE_ARRAY, nullable: true)]
	private ?array $sliderImages = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLinkedIn(): ?string
    {
        return $this->linkedIn;
    }

    public function setLinkedIn(?string $linkedIn): static
    {
        $this->linkedIn = $linkedIn;

        return $this;
    }

    public function getYoutube(): ?string
    {
        return $this->youtube;
    }

    public function setYoutube(?string $youtube): static
    {
        $this->youtube = $youtube;

        return $this;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): static
    {
        $this->instagram = $instagram;

        return $this;
    }

	public function getSliderImages(): ?array
	{
		return $this->sliderImages;
	}

	public function setSliderImages(?array $sliderImages): void
	{
		$this->sliderImages = $sliderImages;
	}
}
