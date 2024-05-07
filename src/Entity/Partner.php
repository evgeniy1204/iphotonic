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

    #[ORM\Column(name: 'contacts', type: Types::TEXT, nullable: true)]
    private ?string $contacts;

	public function __construct()
	{
		$this->id = 0;
		$this->name = null;
		$this->logo = null;
		$this->contacts = null;
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
}
