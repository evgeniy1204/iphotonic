<?php

declare(strict_types=1);

namespace App\Dto;

readonly class BreadcrumbDto
{
	public function __construct(
		private string $text,
		private ?string $url = null,
	){
	}

	public function getUrl(): ?string
	{
		return $this->url;
	}

	public function getText(): string
	{
		return $this->text;
	}
}