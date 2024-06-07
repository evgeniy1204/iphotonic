<?php

declare(strict_types=1);

namespace App\Response;

use App\Dto\CardInfoDto;
use App\Dto\ProductCategoryDto;
use App\Entity\ProductCategory;

readonly class MainProductsCollectionResponse
{
	/**
	 * @param ProductCategoryDto $productCategory
	 * @param CardInfoDto[] $productCards
	 * @param int $order
	 */
	public function __construct(
		private ProductCategoryDto $productCategory,
		private array $productCards,
		private int $order,
	) {
	}

	public function getProductCategory(): ProductCategoryDto
	{
		return $this->productCategory;
	}

	public function getProductCards(): array
	{
		return $this->productCards;
	}

	public function getOrder(): int
	{
		return $this->order;
	}
}