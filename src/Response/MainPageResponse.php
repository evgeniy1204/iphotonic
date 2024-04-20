<?php

namespace App\Response;

use App\Entity\Event;
use App\Entity\News;
use App\Entity\ProductCategory;

readonly class MainPageResponse
{
    /**
     * @param ProductCategory[] $categories
     * @param Event[] $events
     * @param News[] $news
     * @param string[] $membershipLogos
     */
    public function __construct(
        private array $categories = [],
        private array $events = [],
        private array $news = [],
        private array $membershipLogos = [],
    )
    {
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function getEvents(): array
    {
        return $this->events;
    }

    public function getNews(): array
    {
        return $this->news;
    }

    public function getMembershipLogos(): array
    {
        return $this->membershipLogos;
    }
}