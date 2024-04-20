<?php

declare(strict_types=1);

namespace App\Response;

use App\Entity\ProductCategory;

readonly class ProductCategoryResponse
{
    /**
     * @param ProductCategory[] $productCategories
     */
    public function __construct(
        private array $productCategories,
        private ProductCategory $chosenProductCategory
    )
    {
    }

    public function getProductCategories(): array
    {
        return $this->productCategories;
    }

    public function getChosenProductCategory(): ProductCategory
    {
        return $this->chosenProductCategory;
    }
}