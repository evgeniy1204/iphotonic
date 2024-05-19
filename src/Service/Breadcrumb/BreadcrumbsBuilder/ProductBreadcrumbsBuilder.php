<?php

declare(strict_types=1);

namespace App\Service\Breadcrumb\BreadcrumbsBuilder;

use App\Dto\BreadcrumbDto;
use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Service\Breadcrumb\BreadcrumbAwareInterface;
use App\Service\Breadcrumb\BreadcrumbsBuilderInterface;
use App\Service\UrlGenerator;

readonly class ProductBreadcrumbsBuilder implements BreadcrumbsBuilderInterface
{
	public function __construct(private UrlGenerator $urlGenerator)
	{
	}

	/**
	 * @param BreadcrumbAwareInterface|Product $breadcrumbAware
	 * @return BreadcrumbDto[]
	 */
	public function build(BreadcrumbAwareInterface|Product $breadcrumbAware): array
	{
		$breadcrumbs = [];
		$this->generateBreadcrumbs($breadcrumbs, $breadcrumbAware->getCategory());

		return array_reverse($breadcrumbs);
	}

	public function isSupport(BreadcrumbAwareInterface $breadcrumbAware): bool
	{
		return $breadcrumbAware instanceof Product;
	}

	private function generateBreadcrumbs(array &$breadcrumbs, ?ProductCategory $category): void
	{
		if (!$category) {
			return;
		}
		$breadcrumbs[] = new BreadcrumbDto(
			$category->getName(),
			$this->urlGenerator->generateProductCategoryUrl($category)
		);
		$this->generateBreadcrumbs($breadcrumbs, $category->getParent());
	}
}