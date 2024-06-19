<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Setting;

readonly class SocialNetworksDto
{
	private function __construct(
		private string $linkedIn,
		private string $youtube,
		private string $instagram,
		private string $twitter,
	) {
	}

	public static function fromSetting(Setting $setting): self
	{
		return new self(
			$setting->getLinkedIn() ?? '',
			$setting->getInstagram() ?? '',
			$setting->getYoutube() ?? '',
			$setting->getTwitter() ?? ''
		);
	}

	public function getLinkedIn(): string
	{
		return $this->linkedIn;
	}

	public function getYoutube(): string
	{
		return $this->youtube;
	}

	public function getInstagram(): string
	{
		return $this->instagram;
	}

	public function getTwitter(): string
	{
		return $this->twitter;
	}
}