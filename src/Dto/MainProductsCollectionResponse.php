<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Product;
use App\Entity\ProductCategory;

readonly class MainProductsCollectionResponse
{
	/**
	 * @param ProductCategory $productCategory
	 * @param Product[] 	   $products
	 */
	public function __construct(
		private ProductCategory $productCategory,
		private array $products
	) {
	}

	public function getProductCategory(): ProductCategory
	{
		return $this->productCategory;
	}

	public function getProducts(): array
	{
		return $this->products;
	}
}