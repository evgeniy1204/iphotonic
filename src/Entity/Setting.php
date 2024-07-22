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
	public const MAIN_BLOCK_IMAGES_FOLDER = 'main';

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

	#[ORM\Column(name: 'twitter', type: Types::STRING, length: 255, nullable: true)]
	private ?string $twitter;

	#[ORM\Column(name: 'contacts', type: Types::TEXT, nullable: true)]
	private ?string $contacts;

	#[ORM\Column(name: 'about_us', type: Types::TEXT, nullable: true)]
	private ?string $aboutUs;

	#[ORM\Column(name: 'technology_content', type: Types::TEXT, nullable: true)]
	private ?string $technologyContent;

	#[ORM\Column(name: 'main_left_block_title', type: Types::STRING, length: 255, nullable: true)]
	private ?string $mainLeftBlockTitle;

	#[ORM\Column(name: 'main_left_block_title_url', type: Types::STRING, length: 255, nullable: true)]
	private ?string $mainLeftBlockTitleUrl;

	#[ORM\Column(name: 'main_left_block_summary', type: Types::STRING, length: 255, nullable: true)]
	private ?string $mainLeftBlockSummary;

	#[ORM\Column(name: 'main_left_block_image', type: Types::STRING, length: 255, nullable: true)]
	private ?string $mainLeftBlockImage;

	#[ORM\Column(name: 'main_right_block_title', type: Types::STRING, length: 255, nullable: true)]
	private ?string $mainRightBlockTitle;

	#[ORM\Column(name: 'main_right_block_title_url', type: Types::STRING, length: 255, nullable: true)]
	private ?string $mainRightBlockTitleUrl;

	#[ORM\Column(name: 'main_right_block_summary', type: Types::STRING, length: 255, nullable: true)]
	private ?string $mainRightBlockSummary;

	#[ORM\Column(name: 'main_right_block_image', type: Types::STRING, length: 255, nullable: true)]
	private ?string $mainRightBlockImage;

	#[ORM\Column(name: 'phones', type: Types::TEXT, nullable: true)]
	private ?string $phones;

	#[ORM\Column(name: 'email', type: Types::STRING, length: 255, nullable: true)]
	private ?string $email;

	#[ORM\Column(name: 'address', type: Types::STRING, length: 255, nullable: true)]
	private ?string $address;

	#[ORM\Column(name: 'map_asia', type: Types::STRING, length: 255, nullable: true)]
	private ?string $mapAsia;

	#[ORM\Column(name: 'map_europe', type: Types::STRING, length: 255, nullable: true)]
	private ?string $mapEurope;

	public function __construct()
	{
		$this->id = 0;
		$this->linkedIn = null;
		$this->youtube = null;
		$this->instagram = null;
		$this->twitter = null;
		$this->contacts = null;
		$this->aboutUs = null;
		$this->email = null;
		$this->phones = null;
		$this->address = null;
		$this->mainLeftBlockSummary = null;
		$this->mainLeftBlockImage = null;
		$this->mainRightBlockImage = null;
		$this->mainRightBlockSummary = null;
		$this->mainLeftBlockTitleUrl = null;
		$this->mainRightBlockTitleUrl = null;
		$this->mapEurope = null;
		$this->mapAsia = null;
		$this->seo = new SeoEmbed();
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

	public function getMainLeftBlockTitle(): ?string
	{
		return $this->mainLeftBlockTitle;
	}

	public function setMainLeftBlockTitle(?string $mainLeftBlockTitle): void
	{
		$this->mainLeftBlockTitle = $mainLeftBlockTitle;
	}

	public function getMainLeftBlockSummary(): ?string
	{
		return $this->mainLeftBlockSummary;
	}

	public function setMainLeftBlockSummary(?string $mainLeftBlockSummary): void
	{
		$this->mainLeftBlockSummary = $mainLeftBlockSummary;
	}

	public function getMainLeftBlockImage(): ?string
	{
		return $this->mainLeftBlockImage;
	}

	public function setMainLeftBlockImage(?string $mainLeftBlockImage): void
	{
		$this->mainLeftBlockImage = $mainLeftBlockImage;
	}

	public function getMainRightBlockTitle(): ?string
	{
		return $this->mainRightBlockTitle;
	}

	public function setMainRightBlockTitle(?string $mainRightBlockTitle): void
	{
		$this->mainRightBlockTitle = $mainRightBlockTitle;
	}

	public function getMainRightBlockSummary(): ?string
	{
		return $this->mainRightBlockSummary;
	}

	public function setMainRightBlockSummary(?string $mainRightBlockSummary): void
	{
		$this->mainRightBlockSummary = $mainRightBlockSummary;
	}

	public function getMainLeftBlockTitleUrl(): ?string
	{
		return $this->mainLeftBlockTitleUrl;
	}

	public function setMainLeftBlockTitleUrl(?string $mainLeftBlockTitleUrl): void
	{
		$this->mainLeftBlockTitleUrl = $mainLeftBlockTitleUrl;
	}

	public function getMainRightBlockTitleUrl(): ?string
	{
		return $this->mainRightBlockTitleUrl;
	}

	public function setMainRightBlockTitleUrl(?string $mainRightBlockTitleUrl): void
	{
		$this->mainRightBlockTitleUrl = $mainRightBlockTitleUrl;
	}

	public function getTechnologyContent(): ?string
	{
		return $this->technologyContent;
	}

	public function setTechnologyContent(?string $technologyContent): void
	{
		$this->technologyContent = $technologyContent;
	}

	public function getPhones(): ?string
	{
		return $this->phones;
	}

	public function setPhones(?string $phones): void
	{
		$this->phones = $phones;
	}

	public function getEmail(): ?string
	{
		return $this->email;
	}

	public function setEmail(?string $email): void
	{
		$this->email = $email;
	}

	public function getAddress(): ?string
	{
		return $this->address;
	}

	public function setAddress(?string $address): void
	{
		$this->address = $address;
	}

	public function getMainRightBlockImage(): ?string
	{
		return $this->mainRightBlockImage;
	}

	public function setMainRightBlockImage(?string $mainRightBlockImage): void
	{
		$this->mainRightBlockImage = $mainRightBlockImage;
	}

	public function getTwitter(): ?string
	{
		return $this->twitter;
	}

	public function setTwitter(?string $twitter): void
	{
		$this->twitter = $twitter;
	}

	public function getMapAsia(): ?string
	{
		return $this->mapAsia;
	}

	public function setMapAsia(?string $mapAsia): void
	{
		$this->mapAsia = $mapAsia;
	}

	public function getMapEurope(): ?string
	{
		return $this->mapEurope;
	}

	public function setMapEurope(?string $mapEurope): void
	{
		$this->mapEurope = $mapEurope;
	}
}
