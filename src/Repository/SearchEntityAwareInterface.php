<?php

namespace App\Repository;

use App\Service\SearchResultAwareInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(self::SEARCH_ENTITY_TAG)]
interface SearchEntityAwareInterface
{
	public const SEARCH_ENTITY_TAG = 'search_entity_tag';

	/**
	 * @return \Generator<SearchResultAwareInterface>
	 */
	public function search(string $searchText): \Generator;
}