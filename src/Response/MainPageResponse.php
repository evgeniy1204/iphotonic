<?php

namespace App\Response;

use App\Entity\Event;
use App\Entity\News;
use App\Entity\Product;
use App\Entity\ProductCategory;

readonly class MainPageResponse
{
    /**
     * @param ProductCategory[] $parentCategories
     * @param ProductCategory[] $childCategories
     * @param Product[] $products
     * @param Event[] $events
     * @param News[] $news
     */
    public function __construct(
        private array $parentCategories = [],
        private array $childCategories = [],
        private array $products = [],
        private array $events = [],
        private array $news = []
    )
    {
    }

    public function getParentCategories(): array
    {
        return $this->parentCategories;
    }

    public function getChildCategories(): array
    {
        return $this->childCategories;
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function getEvents(): array
    {
        return $this->events;
    }

    public function getNews(): array
    {
        return $this->news;
    }
}