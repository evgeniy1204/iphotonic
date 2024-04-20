<?php

namespace App\Response;

use App\Entity\Event;
use App\Entity\News;
use App\Entity\Product;
use App\Entity\ProductCategory;

readonly class MainPageResponse
{
    /**
     * @param ProductCategory[] $categories
     * @param Product[] $products
     * @param Event[] $events
     * @param News[] $news
     */
    public function __construct(
        private array $categories = [],
        private array $products = [],
        private array $events = [],
        private array $news = []
    )
    {
    }

    public function getCategories(): array
    {
        return $this->categories;
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