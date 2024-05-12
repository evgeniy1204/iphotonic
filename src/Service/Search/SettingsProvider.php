<?php

declare(strict_types=1);

namespace App\Service\Search;

use App\Dto\FooterContactsDto;
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

	private function getSettings(): Setting
	{
		return $this->settingRepository->findSettingPage() ?? throw new LogicException('Settings should be exist');
	}
}