<?php

declare(strict_types=1);

namespace App\Service\Menu;

use App\Dto\MenuItemDto;
use App\Entity\ProductCategory;
use App\Repository\ProductCategoryRepository;
use App\Repository\ProductRepository;
use App\Service\UrlGenerator;

readonly class ProductCategoryMenuProvider
{
	public function __construct(
		private ProductCategoryRepository $productCategoryRepository,
		private ProductRepository $productRepository,
		private UrlGenerator $urlGenerator
	) {
	}

	/**
	 * @return MenuItemDto[]
	 */
	public function provide(int $dept, ?ProductCategory $parent = null): array
	{
		$productCategories = $this->productCategoryRepository->findBy(['parent' => $parent]);
		$menuItems = [];
		$sortFunc = function (MenuItemDto $aDto, MenuItemDto $bDto) {
			return $aDto->getOrder() > $bDto->getOrder();
		};

		/** @var ProductCategory $productCategory */
		foreach ($productCategories as $productCategory) {
			$item = new MenuItemDto(
				$productCategory->getName(),
				$this->urlGenerator->generateProductCategoryUrl($productCategory),
				$productCategory->getMenuOrder(),
			);
			$menuItems[] = $item;

			$products = $this->productRepository->findByCategoryIds([$productCategory->getId(), 100]);
			foreach ($products as $product) {
				$productItem = new MenuItemDto($product->getName(), $this->urlGenerator->generateProductUrl($product), $product->getMenuOrder());
				$item->addChild($productItem);
			}

			$this->generateMenu($dept, $productCategory, $item);
			usort($menuItems, $sortFunc);

			$this->sortMenu($menuItems, $sortFunc);
		}

		return $menuItems;
	}


	private function generateMenu(int $dept, ProductCategory $productCategory, MenuItemDto $parent, int $currentStep = 0): void
	{
		$currentStep++;
		if ($currentStep !== $dept && $productCategory->getChildren()) {
			foreach ($productCategory->getChildren() as $child) {
				$item = new MenuItemDto($child->getName(), $this->urlGenerator->generateProductCategoryUrl($child), $child->getMenuOrder());
				$products = $this->productRepository->findByCategoryIds([$child->getId(), 100]);
				foreach ($products as $product) {
					$productItem = new MenuItemDto($product->getName(), $this->urlGenerator->generateProductUrl($product), $product->getMenuOrder());
					$item->addChild($productItem);
				}
				$parent->addChild($item);
				$this->generateMenu($dept, $child, $item, $currentStep);
			}
		} else {
			$productCategoryIds = $productCategory->getChildren() ? $productCategory->getFinalCategories() : [$productCategory->getId()];
			$products = $this->productRepository->findByCategoryIds($productCategoryIds);
			foreach ($products as $product) {
				$item = new MenuItemDto($product->getName(), $this->urlGenerator->generateProductUrl($product), $product->getMenuOrder());
				$parent->addChild($item);
			}
		}
	}

	/**
	 * @param MenuItemDto[] $menuItems
	 * @param callable $func
	 * @return void
	 */
	private function sortMenu(array $menuItems, callable $sortFunc): void
	{
		foreach ($menuItems as $menuItem) {
			if ($children = $menuItem->getChildren()) {
				$menuItem->sortChildren($sortFunc);
				$this->sortMenu($children, $sortFunc);
			}
		}
	}
}