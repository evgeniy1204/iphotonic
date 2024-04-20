<?php

declare(strict_types=1);

namespace App\Dto\Query;

readonly class ProductCategoryQueryParams
{
    public function __construct(
        private ?int $c = null
    )
    {
    }

    public function getChosenCategory(): ?int
    {
        return $this->c;
    }
}