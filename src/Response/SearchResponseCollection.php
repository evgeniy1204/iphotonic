<?php

declare(strict_types=1);

namespace App\Response;

class SearchResponseCollection
{
	/**
	 * @param SearchResponseItem[] $searchResponseCollection
	 * @param string 			   $searchText
	 */
	public function __construct(
		private readonly string $searchText = 'Search text not provided',
		private array $searchResponseCollection = [],
	) {
	}

	public function addSearchItem(SearchResponseItem $responseItem): void
	{
		$this->searchResponseCollection[] = $responseItem;
	}
}