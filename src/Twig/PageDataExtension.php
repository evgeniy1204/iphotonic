<?php

declare(strict_types=1);

namespace App\Twig;

use App\Dto\BreadcrumbDto;
use App\Dto\MenuItemCollection;
use App\Entity\ProductCategory;
use App\Entity\SeoEmbed;
use App\Entity\Technology;
use App\Repository\CertificateRepository;
use App\Service\Breadcrumb\BreadcrumbAwareInterface;
use App\Service\Breadcrumb\BreadcrumbProvider;
use App\Service\Breadcrumb\BreadcrumbsBuilder\EventBreadcrumbsBuilder;
use App\Service\Breadcrumb\BreadcrumbsBuilder\MediaBreadcrumbsBuilder;
use App\Service\Breadcrumb\BreadcrumbsBuilder\NewsBreadcrumbsBuilder;
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
		private readonly NewsBreadcrumbsBuilder $newsBreadcrumbsBuilder,
		private readonly EventBreadcrumbsBuilder $eventBreadcrumbsBuilder,
		private readonly MediaBreadcrumbsBuilder $mediaBreadcrumbsBuilder,
		private readonly CertificateRepository $certificateRepository,
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
			new TwigFunction('get_footer_data', [$this, 'getFooterData']),
			new TwigFunction('get_site_email', [$this, 'getSiteEmail']),
			new TwigFunction('build_breadcrumbs', [$this, 'buildBreadcrumbs']),
			new TwigFunction('build_news_breadcrumbs', [$this, 'buildNewsBreadcrumbs']),
			new TwigFunction('build_events_breadcrumbs', [$this, 'buildEventsBreadcrumbs']),
			new TwigFunction('build_media_breadcrumbs', [$this, 'buildMediaBreadcrumbs']),
			new TwigFunction('get_default_meta', [$this, 'getMetaTagsData']),
			new TwigFunction('get_site_phones', [$this, 'getSitePhones']),
		];
	}

	public function getSitePhones(): ?string
	{
		return $this->settingsProvider->getPhones();
	}

	public function getFooterData(): array
	{
		return [
			'contacts' => $this->settingsProvider->getFooterInfo(),
			'certificates' => $this->certificateRepository->findAll(),
		];
	}

	public function getSiteEmail(): ?string
	{
		return $this->settingsProvider->getEmail();
	}

	public function generateProductCategoryMenu(int $dept = self::DEFAULT_MENU_DEPT): MenuItemCollection
	{
		return $this->productCategoryMenuProvider->provide($dept);
	}

	public function generateProductCategoryOneLevelMenu(?ProductCategory $parent): MenuItemCollection
	{
		return $this->productCategoryMenuProvider->provide(1, $parent);
	}

	public function generateTechnologyCategoryMenu(int $dept = self::DEFAULT_MENU_DEPT): MenuItemCollection
	{
		return $this->technologyCategoryMenuProvider->provide($dept);
	}

	public function generateTechnologyCategoryOneLevelMenu(?Technology $technology): MenuItemCollection
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

	/**
	 * @param string $currentPage
	 * @return BreadcrumbDto[]
	 */
	public function buildNewsBreadcrumbs(string $currentPage): array
	{
		$breadcrumbs = [];
		$breadcrumbs[] = new BreadcrumbDto(
			$this->siteName,
			$this->router->generate('app_main_page'),
		);
		foreach ($this->newsBreadcrumbsBuilder->build() as $item) {
			if ($item->getText() !== $currentPage) {
				$breadcrumbs[] = $item;
			}
		}
		$breadcrumbs[] = new BreadcrumbDto($currentPage);

		return $breadcrumbs;
	}

	/**
	 * @param string $currentPage
	 * @return BreadcrumbDto[]
	 */
	public function buildEventsBreadcrumbs(string $currentPage): array
	{
		$breadcrumbs = [];
		$breadcrumbs[] = new BreadcrumbDto(
			$this->siteName,
			$this->router->generate('app_main_page'),
		);
		foreach ($this->eventBreadcrumbsBuilder->build() as $item) {
			if ($item->getText() !== $currentPage) {
				$breadcrumbs[] = $item;
			}
		}
		$breadcrumbs[] = new BreadcrumbDto($currentPage);

		return $breadcrumbs;
	}

	/**
	 * @param string $currentPage
	 * @return BreadcrumbDto[]
	 */
	public function buildMediaBreadcrumbs(string $currentPage): array
	{
		$breadcrumbs = [];
		$breadcrumbs[] = new BreadcrumbDto(
			$this->siteName,
			$this->router->generate('app_main_page'),
		);
		foreach ($this->mediaBreadcrumbsBuilder->build() as $item) {
			if ($item->getText() !== $currentPage) {
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