<?php

declare(strict_types=1);

namespace App\Twig;

use App\Dto\BreadcrumbDto;
use App\Dto\FooterContactsDto;
use App\Entity\ProductCategory;
use App\Entity\SeoEmbed;
use App\Entity\Technology;
use App\Service\Breadcrumb\BreadcrumbAwareInterface;
use App\Service\Breadcrumb\BreadcrumbProvider;
use App\Service\Menu\ProductCategoryMenuProvider;
use App\Service\Menu\TechnologyCategoryMenuProvider;
use App\Service\Search\SettingsProvider;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Routing\RouterInterface;
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
		private readonly BreadcrumbProvider $breadcrumbProvider,
		private readonly RouterInterface $router,
		#[Autowire('%env(SITE_NAME)%')] private readonly string $siteName
	) {
	}

	/**
	 * @return TwigFunction[]
	 */
	public function getFunctions(): array
	{
		return [
			new TwigFunction('generate_product_category_menu', [$this, 'generateProductCategoryMenu']),
			new TwigFunction('generate_product_category_one_level_menu', [$this, 'generateProductCategoryOneLevelMenu']),
			new TwigFunction('generate_technology_category_menu', [$this, 'generateTechnologyCategoryMenu']),
			new TwigFunction('generate_technology_category_one_level_menu', [$this, 'generateTechnologyCategoryOneLevelMenu']),
			new TwigFunction('get_footer_contacts', [$this, 'getFooterContacts']),
			new TwigFunction('build_breadcrumbs', [$this, 'buildBreadcrumbs']),
			new TwigFunction('get_default_meta', [$this, 'getMetaTagsData']),
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

	public function generateProductCategoryOneLevelMenu(?ProductCategory $parent): array
	{
		return $this->productCategoryMenuProvider->provide(1, $parent);
	}

	public function generateTechnologyCategoryMenu(int $dept = self::DEFAULT_MENU_DEPT): array
	{
		return $this->technologyCategoryMenuProvider->provide($dept);
	}

	public function generateTechnologyCategoryOneLevelMenu(?Technology $technology): array
	{
		return $this->technologyCategoryMenuProvider->provide(1, $technology);
	}

	public function buildBreadcrumbs(string $currentPage, ?BreadcrumbAwareInterface $breadcrumbAware): array
	{
		$breadcrumbs = [];
		$breadcrumbs[] = new BreadcrumbDto(
			$this->siteName,
			$this->router->generate('app_main_page'),
		);
		if ($breadcrumbAware) {
			foreach ($this->breadcrumbProvider->buildBreadcrumb($breadcrumbAware) as $item) {
				$breadcrumbs[] = $item;
			}
		}
		$breadcrumbs[] = new BreadcrumbDto($currentPage);

		return $breadcrumbs;
	}

	public function getMetaTagsData(): SeoEmbed
	{
		return $this->settingsProvider->getSeo();
	}
}