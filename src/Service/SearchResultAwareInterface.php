<?php

namespace App\Service;

use App\Enum\SearchResultTypeEnum;

interface SearchResultAwareInterface
{
	public function getSearchResultType(): SearchResultTypeEnum;
	public function getSearchResultTitle(): ?string;
	public function getSearchedResultShortText(): ?string;
	public function getSearchResultSlug(): ?string;
}