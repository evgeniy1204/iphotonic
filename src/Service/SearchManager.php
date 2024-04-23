<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\EventRepository;
use App\Repository\NewsRepository;
use App\Repository\ProductRepository;
use App\Repository\TechnologyRepository;
use App\Response\SearchResponseItem;

readonly class SearchManager
{
	public function __construct(
		private ProductRepository $productRepository,
		private TechnologyRepository $technologyRepository,
		private NewsRepository $newsRepository,
		private EventRepository $eventRepository,
		private UrlGenerator $urlGenerator
	) {
	}

	/**
	 * @param string $searchText
	 * @return \Generator<SearchResponseItem>
	 */
	public function searchByText(string $searchText): \Generator
	{
		foreach ($this->productRepository->search($searchText) as $product) {
			yield new SearchResponseItem(
				$product->getSearchResultType(),
				$product->getSearchResultTitle(),
				$product->getSearchedResultShortText(),
				$this->urlGenerator->generateProductUrl($product),
			);
		}

		foreach ($this->technologyRepository->search($searchText) as $technology) {
			yield new SearchResponseItem(
				$technology->getSearchResultType(),
				$technology->getSearchResultTitle(),
				$technology->getSearchedResultShortText(),
				$this->urlGenerator->generateTechnologyUrl($technology),
			);
		}

		foreach ($this->newsRepository->search($searchText) as $news) {
			yield new SearchResponseItem(
				$news->getSearchResultType(),
				$news->getSearchResultTitle(),
				$news->getSearchedResultShortText(),
				$this->urlGenerator->generateNewsUrl($news),
			);
		}

		foreach ($this->eventRepository->search($searchText) as $event) {
			yield new SearchResponseItem(
				$event->getSearchResultType(),
				$event->getSearchResultTitle(),
				$event->getSearchedResultShortText(),
				$this->urlGenerator->generateEventUrl($event),
			);
		}
	}
}