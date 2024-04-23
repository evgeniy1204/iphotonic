<?php

declare(strict_types=1);

namespace App\Twig;

use App\Dto\FooterContactsDto;
use App\Service\MenuProvider\ProductCategoryMenuProvider;
use App\Service\MenuProvider\TechnologyCategoryMenuProvider;
use App\Service\SettingsProvider;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

#[AutoconfigureTag('twig.extension')]
class PageDataExtension extends AbstractExtension
{
	private const DEFAULT_MENU_DEPT = 3;

	public function __construct(
		private readonly ProductCategoryMenuProvider $productCategoryMenuProvider,
		private readonly TechnologyCategoryMenuProvider $technologyCategoryMenuProvider,
		private readonly SettingsProvider $settingsProvider,
	) {
	}

	/**
	 * @return TwigFunction[]
	 */
	public function getFunctions(): array
	{
		return [
			new TwigFunction('generate_product_category_menu', [$this, 'generateProductCategoryMenu']),
			new TwigFunction('generate_technology_category_menu', [$this, 'generateTechnologyCategoryMenu']),
			new TwigFunction('get_footer_contacts', [$this, 'getFooterContacts']),
		];
	}

	public function getFooterContacts(): FooterContactsDto
	{
		return $this->settingsProvider->getFooterInfo();
	}

	public function generateProductCategoryMenu(int $dept = self::DEFAULT_MENU_DEPT): array
	{
		return $this->productCategoryMenuProvider->provide($dept);
	}

	public function generateTechnologyCategoryMenu(int $dept = self::DEFAULT_MENU_DEPT): array
	{
		return $this->technologyCategoryMenuProvider->provide($dept);
	}
}