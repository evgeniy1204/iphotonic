<?php

namespace App\Service\Search;

use App\Enum\SearchResultTypeEnum;

interface SearchResultAwareInterface
{
	public function getSearchResultType(): SearchResultTypeEnum;
	public function getSearchResultTitle(): ?string;
	public function getSearchedResultShortText(): ?string;
}