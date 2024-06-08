<?php

namespace App\Entity;

use App\Repository\CertificateRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CertificateRepository::class)]
class Certificate
{
	public const CERTIFICATE_FOLDER = 'certificate';

	#[
		ORM\Id,
		ORM\GeneratedValue,
		ORM\Column(name: 'id')
	]
    private int $id;

    #[ORM\Column(name: 'url', type: Types::STRING, length: 255, nullable: true)]
    private ?string $url;

    #[ORM\Column(name: 'logo', type: Types::STRING, length: 255, nullable: true)]
    private ?string $logo;

	public function __construct()
	{
		$this->id = 0;
		$this->url = null;
		$this->logo = null;
	}

	public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }
}
