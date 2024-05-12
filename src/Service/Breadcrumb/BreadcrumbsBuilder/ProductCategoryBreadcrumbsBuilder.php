<?php

declare(strict_types=1);

namespace App\Service\Breadcrumb\BreadcrumbsBuilder;

use App\Dto\BreadcrumbDto;
use App\Entity\ProductCategory;
use App\Service\Breadcrumb\BreadcrumbAwareInterface;
use App\Service\Breadcrumb\BreadcrumbsBuilderInterface;
use App\Service\UrlGenerator;

readonly class ProductCategoryBreadcrumbsBuilder implements BreadcrumbsBuilderInterface
{
	public function __construct(private UrlGenerator $urlGenerator)
	{
	}

	/**
	 * @param BreadcrumbAwareInterface|ProductCategory $breadcrumbAware
	 * @return BreadcrumbDto[]
	 */
	public function build(BreadcrumbAwareInterface|ProductCategory $breadcrumbAware): array
	{
		$breadcrumbs = [];
		$breadcrumbs[] = new BreadcrumbDto($breadcrumbAware->getName());
		$this->generateBreadcrumbs($breadcrumbs, $breadcrumbAware->getParent());

		return array_reverse($breadcrumbs);
	}

	public function isSupport(BreadcrumbAwareInterface $breadcrumbAware): bool
	{
		return $breadcrumbAware instanceof ProductCategory;
	}

	/**
	 * @param BreadcrumbDto[]      $breadcrumbs
	 * @param ProductCategory|null $category
	 * @return void
	 */
	private function generateBreadcrumbs(array &$breadcrumbs, ?ProductCategory $category): void
	{
		if (!$category) {
			return;
		}
		$breadcrumbs[] = new BreadcrumbDto(
			$category->getName(),
			$this->urlGenerator->generateProductCategoryUrl($category)
		);
		if ($category->getParent()) {
			$this->generateBreadcrumbs($breadcrumbs, $category->getParent());
		}
	}
}