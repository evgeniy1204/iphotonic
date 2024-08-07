<?php

declare(strict_types=1);

namespace App\Service\Search;

use App\Dto\FooterContactsDto;
use App\Dto\SocialNetworksDto;
use App\Entity\SeoEmbed;
use App\Entity\Setting;
use App\Repository\SettingRepository;
use LogicException;

readonly class SettingsProvider
{
	public function __construct(private SettingRepository $settingRepository)
	{
	}

	public function getFooterInfo(): FooterContactsDto
	{
		return FooterContactsDto::fromSetting($this->getSettings());
	}

	public function getSeo(): SeoEmbed
	{
		return $this->getSettings()->getSeo();
	}

	public function getSettings(): Setting
	{
		return $this->settingRepository->findSettingPage() ?? throw new LogicException('Settings should be exist');
	}

	public function getTechnologyContent(): ?string
	{
		return $this->getSettings()->getTechnologyContent();
	}

	public function getAboutUsContent(): ?string
	{
		return $this->getSettings()->getAboutUs();
	}

	public function getContacts(): ?string
	{
		return $this->getSettings()->getContacts();
	}

	public function getEmail(): ?string
	{
		return $this->getSettings()->getEmail();
	}

	public function getPhones(): ?string
	{
		return $this->getSettings()->getPhones();
	}

	public function getSocialLinks(): ?SocialNetworksDto
	{
		return SocialNetworksDto::fromSetting($this->getSettings());
	}

	public function getMapAsia(): ?string
	{
		return $this->getSettings()->getMapAsia();
	}

	public function getMapEurope(): ?string
	{
		return $this->getSettings()->getMapEurope();
	}
}