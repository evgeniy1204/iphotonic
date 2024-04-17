<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\MenuItem;
use App\Entity\ProductCategory;
use App\Repository\ProductCategoryRepository;

readonly class MenuProvider
{
	public function __construct(private ProductCategoryRepository $productCategoryRepository)
	{
	}

	/**
	 * @return MenuItem[]
	 */
	public function provide(int $dept): array
	{
		$productCategories = $this->productCategoryRepository->findBy(['parent' => null]);
		$menuItems = [];

		foreach ($productCategories as $productCategory) {
			$item = new MenuItem($productCategory->getName(), (string)$productCategory->getId());
			$menuItems[] = $item;

			$this->generateMenu($dept, $productCategory, $item);
		}

		return $menuItems;
	}

	private function generateMenu(int $dept, ProductCategory $productCategory, MenuItem $parent, int $currentStep = 0): void
	{
		$currentStep++;
		if ($currentStep === $dept) {
			return;
		}
		foreach ($productCategory->getChildren() as $child) {
			$item = new MenuItem($child->getName(), (string)$child->getId());
			$parent->addChild($item);
			$this->generateMenu($dept, $child, $item, $currentStep);
		}
	}
}