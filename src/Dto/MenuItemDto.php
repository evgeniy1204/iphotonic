<?php

declare(strict_types=1);

namespace App\Dto;

class MenuItemDto
{
	public function __construct(
		private readonly string $name,
		private readonly string $url,
		private array $children = []
	) {
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getUrl(): string
	{
		return $this->url;
	}

	public function addChild(MenuItemDto $item): void
	{
		$this->children[] = $item;
	}

	/**
	 * @return MenuItemDto[]
	 */
	public function getChildren(): array
	{
		return $this->children;
	}
}