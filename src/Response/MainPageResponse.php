<?php

namespace App\Response;

use App\Entity\Event;
use App\Entity\News;
use App\Entity\SeoEmbed;
use App\Entity\Setting;

readonly class MainPageResponse
{
	/**
	 * @param Setting $setting
	 * @param MainProductsCollectionResponse[] $productsWithCategory
	 * @param Event[] $events
	 * @param News[] $news
	 * @param string[] $membershipLogos
	 */
    public function __construct(
		private Setting $setting,
        private array $productsWithCategory = [],
        private array $events = [],
        private array $news = [],
        private array $membershipLogos = [],
    ) {
    }

	/**
	 * @return MainProductsCollectionResponse[]
	 */
    public function getProductsWithCategory(): array
    {
        return $this->productsWithCategory;
    }

	/**
	 * @return Event[]
	 */
    public function getEvents(): array
    {
        return $this->events;
    }

	/**
	 * @return News[]
	 */
    public function getNews(): array
    {
        return $this->news;
    }

	/**
	 * @return string[]
	 */
    public function getMembershipLogos(): array
    {
        return $this->membershipLogos;
    }

	public function getSetting(): Setting
	{
		return $this->setting;
	}
}
