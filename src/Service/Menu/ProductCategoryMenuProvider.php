<?php

declare(strict_types=1);

namespace App\Service\Menu;

use App\Dto\MenuItemDto;
use App\Entity\ProductCategory;
use App\Repository\ProductCategoryRepository;
use App\Repository\ProductRepository;
use App\Service\UrlGenerator;
use Symfony\Component\Routing\RouterInterface;

readonly class ProductCategoryMenuProvider
{
	public function __construct(
		private ProductCategoryRepository $productCategoryRepository,
		private ProductRepository $productRepository,
		private RouterInterface $router,
		private UrlGenerator $urlGenerator
	) {
	}

	/**
	 * @return MenuItemDto[]
	 */
	public function provide(int $dept): array
	{
		$productCategories = $this->productCategoryRepository->findBy(['parent' => null]);
		$menuItems = [];

		foreach ($productCategories as $productCategory) {
			$item = new MenuItemDto(
				$productCategory->getName(),
				$this->router->generate('app_product_category', ['productCategorySlug' => $productCategory->getSlug()])
			);
			$menuItems[] = $item;

			$this->generateMenu($dept, $productCategory, $item);
		}

		return $menuItems;
	}


	private function generateMenu(int $dept, ProductCategory $productCategory, MenuItemDto $parent, int $currentStep = 0): void
	{
		$currentStep++;
		if ($currentStep === $dept) {
			return;
		}
		if (!$productCategory->getChildren()->isEmpty()) {
			foreach ($productCategory->getChildren() as $child) {
				$item = new MenuItemDto($child->getName(), $this->urlGenerator->generateProductCategoryUrl($child));
				$parent->addChild($item);
				$this->generateMenu($dept, $child, $item, $currentStep);
			}
		} else {
			$products = $this->productRepository->findByCategoryId($productCategory->getId());
			foreach ($products as $product) {
				$item = new MenuItemDto($product->getName(), $this->urlGenerator->generateProductUrl($product));
				$parent->addChild($item);
			}
		}
	}
}