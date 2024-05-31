<?php

declare(strict_types=1);

namespace App\Response;

use App\Dto\CardInfoDto;
use App\Entity\ProductCategory;

readonly class MainProductsCollectionResponse
{
	/**
	 * @param ProductCategory $productCategory
	 * @param CardInfoDto[]   $productCards
	 */
	public function __construct(
		private ProductCategory $productCategory,
		private array $productCards
	) {
	}

	public function getProductCategory(): ProductCategory
	{
		return $this->productCategory;
	}

	public function getProductCards(): array
	{
		return $this->productCards;
	}
}