<?php

declare(strict_types=1);

namespace App\Dto;

class MenuItemDto
{
	public function __construct(
		private readonly string $name,
		private readonly string $url,
		private readonly int $order,
		private ?MenuItemDto $parent = null,
		private array $children = [],
		private bool $isActive = false,
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
		$item->setParent($this);
		$this->children[] = $item;
	}

	/**
	 * @return MenuItemDto[]
	 */
	public function getChildren(): array
	{
		return $this->children;
	}

	public function getOrder(): int
	{
		return $this->order;
	}

	public function sortChildren(callable $sortFunc): void
	{
		usort($this->children, $sortFunc);
	}

	public function isActive(): bool
	{
		return $this->isActive;
	}

	public function markActive(): void
	{
		$this->isActive = true;
	}

	public function resolveActive(string $currentPath): void
	{
		$this->isActive = $this->url === $currentPath;
	}

	public function getParent(): ?MenuItemDto
	{
		return $this->parent;
	}

	private function setParent(MenuItemDto $parent): void
	{
		$this->parent = $parent;
	}
}