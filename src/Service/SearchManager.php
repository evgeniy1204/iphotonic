<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\SearchResultTypeEnum;
use App\Repository\ProductRepository;
use Symfony\Component\Routing\RouterInterface;

readonly class SearchManager
{
	public function __construct(
		private RouterInterface   $router,
		private ProductRepository $productRepository
	)
	{
	}

	/**
	 * @param string $searchText
	 * @return \Generator<SearchResultAwareInterface>
	 */
	public function searchByText(string $searchText): \Generator
	{
		foreach ($this->productRepository->search($searchText) as $searchResult) {
			yield $searchResult;
		}
	}

	public function generateResultUrl(SearchResultTypeEnum $typeEnum, string $slug): string
	{
		return 'will be url';//$this->router->generate('home');
	}
}