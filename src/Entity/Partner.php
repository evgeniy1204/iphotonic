<?php

namespace App\Entity;

use App\Repository\PartnerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[
    ORM\Entity(repositoryClass: PartnerRepository::class),
    ORM\Table(name: 'partners')
]
class Partner
{
    const PARTNERS_FOLDER = 'partner';
    #[
        ORM\Id,
        ORM\GeneratedValue,
        ORM\Column(name: 'id')
    ]
    private int $id;

    #[ORM\Column(name: 'name', length: 255, nullable: true)]
    private ?string $name;

    #[ORM\Column(name: 'logo', type: Types::STRING, length: 255, nullable: true)]
    private ?string $logo;

	#[ORM\Column(name: 'map_name', type: Types::STRING, length: 255, nullable: true)]
	private ?string $mapName;

	#[ORM\Column(name: 'map', type: Types::STRING, length: 255, nullable: true)]
	private ?string $map;

	#[ORM\Column(name: 'map_position_top', type: Types::INTEGER, nullable: true)]
	private ?int $mapPositionTop;

	#[ORM\Column(name: 'map_position_left', type: Types::INTEGER, nullable: true)]
	private ?int $mapPositionLeft;

    #[ORM\Column(name: 'contacts', type: Types::TEXT, nullable: true)]
    private ?string $contacts;

	#[ORM\Column(name: 'show_partner_card', type: Types::BOOLEAN)]
	private bool $showPartnerCard;

	public function __construct()
	{
		$this->id = 0;
		$this->name = null;
		$this->logo = null;
		$this->mapName = null;
		$this->map = null;
		$this->mapPositionLeft = null;
		$this->mapPositionTop = null;
		$this->contacts = null;
		$this->showPartnerCard = true;
	}

	public function getId(): int
    {
        return $this->id;
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

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    public function getContacts(): ?string
    {
        return $this->contacts;
    }

    public function setContacts(string $contacts): static
    {
        $this->contacts = $contacts;

        return $this;
    }

	public function getMapPositionTop(): ?int
	{
		return $this->mapPositionTop;
	}

	public function setMapPositionTop(?int $mapPositionTop): void
	{
		$this->mapPositionTop = $mapPositionTop;
	}

	public function getMapName(): ?string
	{
		return $this->mapName;
	}

	public function setMapName(?string $mapName): void
	{
		$this->mapName = $mapName;
	}

	public function getMapPositionLeft(): ?int
	{
		return $this->mapPositionLeft;
	}

	public function setMapPositionLeft(?int $mapPositionLeft): void
	{
		$this->mapPositionLeft = $mapPositionLeft;
	}

	public function getMap(): ?string
	{
		return $this->map;
	}

	public function setMap(?string $map): void
	{
		$this->map = $map;
	}

	public function isShowPartnerCard(): bool
	{
		return $this->showPartnerCard;
	}

	public function setShowPartnerCard(bool $showPartnerCard): void
	{
		$this->showPartnerCard = $showPartnerCard;
	}
}
