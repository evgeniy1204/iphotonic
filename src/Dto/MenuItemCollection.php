<?php

declare(strict_types=1);

namespace App\Dto;

readonly class MenuItemCollection
{
	/**
	 * @param MenuItemDto[] $items
	 */
	public function __construct(private array $items = [])
	{
	}

	public function getItems(): array
	{
		return $this->items;
	}

	public function resolveActive(string $currentPath): void
	{
		$this->resolveActiveItems($this->items, $currentPath);
	}

	/**
	 * @param MenuItemDto[] $items
	 * @param string 		$currentPath
	 * @return void
	 */
	private function resolveActiveItems(array $items, string $currentPath): void
	{
		foreach ($items as $item) {
			$item->resolveActive($currentPath);
			if ($item->isActive()) {
				$this->doActiveForLastParent($item);
			} else {
				$this->resolveActiveItems($item->getChildren(), $currentPath);
			}
		}
	}

	private function doActiveForLastParent(MenuItemDto $item): void
	{
		if ($parent = $item->getParent()) {
			$parent->markActive();
			$this->doActiveForLastParent($parent);
		}
	}
}