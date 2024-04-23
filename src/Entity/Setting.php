<?php

namespace App\Entity;

use App\Constants;
use App\Repository\SettingRepository;
use App\Trait\SeoFieldsTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[
	ORM\Entity(repositoryClass: SettingRepository::class),
	ORM\Table(name: 'settings')
]
class Setting
{
	public const MEMBERSHIP_IMAGES_FOLDER = 'membership';

	use SeoFieldsTrait;

    #[
		ORM\Id,
		ORM\GeneratedValue,
		ORM\Column(name: 'id')
	]
    private int $id;

    #[ORM\Column(name: 'linked_in', type: Types::STRING, length: 255, nullable: true)]
    private ?string $linkedIn;

    #[ORM\Column(name: 'youtube', type: Types::STRING, length: 255, nullable: true)]
    private ?string $youtube;

    #[ORM\Column(name: 'instagram', type: Types::STRING, length: 255, nullable: true)]
    private ?string $instagram;

	#[ORM\Column(name: 'membership_logos', type: Types::SIMPLE_ARRAY, nullable: true)]
	private ?array $membershipLogos;

	#[ORM\Column(name: 'contacts', type: Types::TEXT, nullable: true)]
	private ?string $contacts;

	#[ORM\Column(name: 'about_us', type: Types::TEXT, nullable: true)]
	private ?string $aboutUs;

	public function __construct()
	{
		$this->id = 0;
		$this->linkedIn = null;
		$this->youtube = null;
		$this->instagram = null;
		$this->contacts = null;
		$this->aboutUs = null;
		$this->membershipLogos = null;
	}

	public function getId(): int
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

	public function getMembershipLogos(): array
	{
		return $this->membershipLogos;
	}

	public function getMembershipLogoPaths(): array
	{
		$fullPaths = [];
		foreach ($this->membershipLogos as $membershipLogo) {
			$fullPaths[] = sprintf('%s%s/%s', Constants::ADMIN_ROOT_READ_IMAGES_DIR, self::MEMBERSHIP_IMAGES_FOLDER, $membershipLogo);
		}
		return $fullPaths;
	}

	public function setMembershipLogos(?array $membershipLogos): void
	{
		$this->membershipLogos = $membershipLogos;
	}

	public function getContacts(): ?string
	{
		return $this->contacts;
	}

	public function setContacts(?string $contacts): void
	{
		$this->contacts = $contacts;
	}

	public function getAboutUs(): ?string
	{
		return $this->aboutUs;
	}

	public function setAboutUs(?string $aboutUs): void
	{
		$this->aboutUs = $aboutUs;
	}
}
