<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\FooterContactsDto;
use App\Entity\Setting;
use App\Repository\SettingRepository;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FilterConfigDto;
use LogicException;

readonly class SettingsProvider
{
	public function __construct(private SettingRepository $settingRepository)
	{
	}

	public function getMemberships(): array
	{
		return $this->getSettings()->getMembershipLogoPaths();
	}

	public function getFooterInfo(): FooterContactsDto
	{
		return FooterContactsDto::fromSetting($this->getSettings());
	}

	private function getSettings(): Setting
	{
		return $this->settingRepository->findSettingPage() ?? throw new LogicException('Settings should be exist');
	}
}