<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\SearchResultTypeEnum;
use App\Repository\ProductRepository;
use App\Repository\SearchEntityAwareInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use Symfony\Component\Routing\RouterInterface;

readonly class SearchManager
{
	/**
	 * @param RouterInterface $router
	 * @param iterable<SearchEntityAwareInterface> $searchRepositories
	 */
	public function __construct(
		private RouterInterface $router,
		#[TaggedIterator(tag: SearchEntityAwareInterface::SEARCH_ENTITY_TAG)] private iterable $searchRepositories
	) {
	}

	/**
	 * @param string $searchText
	 * @return \Generator<SearchResultAwareInterface>
	 */
	public function searchByText(string $searchText): \Generator
	{
		foreach ($this->searchRepositories as $searchRepository) {
			foreach ($searchRepository->search($searchText) as $searchResult) {
				if (!$searchResult instanceof SearchResultAwareInterface) {
					continue;
				}
				yield $searchResult;
			}
		}
	}

	public function generateResultUrl(SearchResultTypeEnum $typeEnum, string $slug): string
	{
		return 'will be url';//$this->router->generate('home');
	}
}