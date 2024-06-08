<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Setting;

readonly class FooterContactsDto
{
	private function __construct(
		private ?string $contacts,
		private SocialNetworksDto $socialNetworksDto
	) {
	}

	public static function fromSetting(Setting $setting): self
	{
		return new self($setting->getAddress(), SocialNetworksDto::fromSetting($setting));
	}

	public function getContacts(): ?string
	{
		return $this->contacts;
	}

	public function getSocialNetworksDto(): SocialNetworksDto
	{
		return $this->socialNetworksDto;
	}
}