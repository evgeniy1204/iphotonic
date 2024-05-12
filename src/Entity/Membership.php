<?php

namespace App\Entity;

use App\Constants;
use App\Repository\MembershipRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembershipRepository::class)]
class Membership
{
	public const MEMBERSHIP_IMAGES_FOLDER = 'membership';

	#[
		ORM\Id,
		ORM\GeneratedValue,
		ORM\Column(name: 'id')
	]
    private int $id;

    #[ORM\Column(name: 'logo', type: Types::STRING, length: 255)]
    private ?string $logo;

    #[ORM\Column(name: 'url', type: Types::STRING, length: 255)]
    private ?string $url;

	public function __construct()
	{
		$this->id = 0;
		$this->logo = null;
		$this->url = null;
	}

	public function getId(): int
    {
        return $this->id;
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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

	public function getMembershipLogoPath(): string
	{
		return sprintf('%s%s/%s', Constants::ADMIN_ROOT_READ_IMAGES_DIR, self::MEMBERSHIP_IMAGES_FOLDER, $this->logo);
	}
}
