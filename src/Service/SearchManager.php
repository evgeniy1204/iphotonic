<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\SearchResultTypeEnum;
use App\Repository\ProductRepository;
use Symfony\Component\Routing\RouterInterface;

readonly class SearchManager
{
	public function __construct(
		private ProductRepository $productRepository,
		private RouterInterface $router
	){
	}

	/**
	 * @param string $searchText
	 * @return \Generator<SearchResultAwareInterface>
	 */
	public function searchByText(string $searchText): \Generator
	{
		//TODO: to like query to search
		foreach ($this->productRepository->findAll() as $product) {
			yield $product;
		}
		//TODO: add technology
		//TODO: add news
		//TODO: add events
	}

	public function generateResultUrl(SearchResultTypeEnum $typeEnum, string $slug): string
	{
		return '';//$this->router->generate('home');
	}
}