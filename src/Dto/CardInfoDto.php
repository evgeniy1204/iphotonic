<?php

declare(strict_types=1);

namespace App\Dto;

readonly class CardInfoDto
{
	public function __construct(
		private string $imageUrl,
		private string $url,
		private string $name,
		private ?string $summary,
		private int $orderNumber,
	) {
	}

	public function getOrderNumber(): int
	{
		return $this->orderNumber;
	}

	public function getImageUrl(): string
	{
		return $this->imageUrl;
	}

	public function getUrl(): string
	{
		return $this->url;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getSummary(): ?string
	{
		return $this->summary;
	}
}