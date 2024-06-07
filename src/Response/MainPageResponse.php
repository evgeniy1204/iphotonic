<?php

namespace App\Response;

use App\Entity\Event;
use App\Entity\News;
use App\Entity\Setting;

class MainPageResponse
{
	/**
	 * @param Setting $setting
	 * @param MainProductsCollectionResponse[] $productsWithCategory
	 * @param Event[] $events
	 * @param News[] $news
	 * @param string[] $membershipLogos
	 */
    public function __construct(
		private readonly Setting $setting,
        private array $productsWithCategory = [],
        private readonly array $events = [],
        private readonly array $news = [],
        private readonly array $membershipLogos = [],
    ) {
		$this->sort($this->productsWithCategory, $this->getSortFunc());
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

	/**
	 * @param array $items
	 * @param callable $sortFunc
	 * @return void
	 */
	private function sort(array $items, callable $sortFunc): void
	{
		foreach ($items as $key => $children) {
			usort($children, $sortFunc);
			$items[$key] = $children;
		}
		$this->productsWithCategory = $items;
	}

	private function getSortFunc(): callable
	{
		return function (MainProductsCollectionResponse $aDto, MainProductsCollectionResponse $bDto) {
			return $aDto->getOrder() > $bDto->getOrder();
		};
	}
}
