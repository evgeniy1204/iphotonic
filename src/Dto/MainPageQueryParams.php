<?php

declare(strict_types=1);

namespace App\Dto;

readonly class MainPageQueryParams
{
    public function __construct(
        private ?int $p = null,
        private ?int $c = null,
    )
    {
    }

    public function getParentCategoryId(): ?int
    {
        return $this->p;
    }

    public function getChildCategoryId(): ?int
    {
        return $this->c;
    }
}