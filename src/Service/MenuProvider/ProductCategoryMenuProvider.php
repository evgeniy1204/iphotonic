<?php

declare(strict_types=1);

namespace App\Service\MenuProvider;

use App\Dto\MenuItem;
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
	 * @return MenuItem[]
	 */
	public function provide(int $dept): array
	{
		$productCategories = $this->productCategoryRepository->findBy(['parent' => null]);
		$menuItems = [];

		foreach ($productCategories as $productCategory) {
			$item = new MenuItem(
				$productCategory->getName(),
				$this->router->generate('app_product_category', ['productCategorySlug' => $productCategory->getSlug()])
			);
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
		if (!$productCategory->getChildren()->isEmpty()) {
			foreach ($productCategory->getChildren() as $child) {
				$item = new MenuItem($child->getName(), $this->urlGenerator->generateProductCategoryUrl($child));
				$parent->addChild($item);
				$this->generateMenu($dept, $child, $item, $currentStep);
			}
		} else {
			$products = $this->productRepository->findByCategoryId($productCategory->getId());
			foreach ($products as $product) {
				$item = new MenuItem($product->getName(), $this->urlGenerator->generateProductUrl($product));
				$parent->addChild($item);
			}
		}
	}
}