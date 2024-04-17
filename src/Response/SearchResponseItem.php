<?php

declare(strict_types=1);

namespace App\Response;

use App\Enum\SearchResultTypeEnum;

class SearchResponseItem
{
	public function __construct(
		private SearchResultTypeEnum $type,
		private string $title,
		private string $text,
		private string $url,
	) {
	}

	public function getType(): SearchResultTypeEnum
	{
		return $this->type;
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function getText(): string
	{
		return $this->text;
	}

	public function getUrl(): string
	{
		return $this->url;
	}
}