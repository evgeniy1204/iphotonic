<?php

declare(strict_types=1);

namespace App\Service\Menu;

use App\Dto\MenuItemCollection;
use App\Dto\MenuItemDto;
use App\Entity\ProductCategory;
use App\Repository\ProductCategoryRepository;
use App\Repository\ProductRepository;
use App\Service\UrlGenerator;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;

readonly class ProductCategoryMenuProvider
{
	public function __construct(
		private ProductCategoryRepository $productCategoryRepository,
		private ProductRepository         $productRepository,
		private UrlGenerator              $urlGenerator,
		private RequestStack 			  $requestStack
	) {
	}

	public function provide(int $dept, ?ProductCategory $parent = null): MenuItemCollection
	{
		$productCategories = $this->productCategoryRepository->findBy(['parent' => $parent]);
		$menuItems = [];

		/** @var ProductCategory $productCategory */
		foreach ($productCategories as $productCategory) {
			$item = new MenuItemDto(
				$productCategory->getName(),
				$this->urlGenerator->generateProductCategoryUrl($productCategory),
				$productCategory->getMenuOrder(),
			);
			$menuItems[] = $item;

			$products = $this->productRepository->findByCategoryIds([$productCategory->getId()]);
			foreach ($products as $product) {
				$productItem = new MenuItemDto($product->getName(), $this->urlGenerator->generateProductUrl($product), $product->getMenuOrder());
				$item->addChild($productItem);
			}

			$this->generateMenu($dept, $productCategory, $item);
		}

		return new MenuItemCollection($this->getCurrentPath(), $menuItems);
	}


	private function generateMenu(int $dept, ProductCategory $productCategory, MenuItemDto $parent, int $currentStep = 0): void
	{
		$currentStep++;
		if ($currentStep === $dept) {
			return;
		}
		foreach ($productCategory->getChildren() as $child) {
			$item = new MenuItemDto($child->getName(), $this->urlGenerator->generateProductCategoryUrl($child), $child->getMenuOrder());
			$products = $this->productRepository->findByCategoryIds([$child->getId()]);
			foreach ($products as $product) {
				$productItem = new MenuItemDto($product->getName(), $this->urlGenerator->generateProductUrl($product), $product->getMenuOrder());
				$item->addChild($productItem);
			}
			$parent->addChild($item);
			$this->generateMenu($dept, $child, $item, $currentStep);
		}
	}

	private function getCurrentPath(): string
	{
		$currentRequest = $this->requestStack->getCurrentRequest();

		return $currentRequest->getPathInfo();
	}
}