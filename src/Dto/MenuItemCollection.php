<?php

declare(strict_types=1);

namespace App\Dto;

readonly class MenuItemCollection
{
	/**
	 * @param string|null $currentPath
	 * @param MenuItemDto[] $items
	 */
	public function __construct(
		private ?string $currentPath,
		private array   $items = []
	)
	{
		if ($this->currentPath) {
			$this->resolveActiveItems($this->items, $currentPath);
		}
		$this->sortMenu($this->items, $this->getSortFunc());
	}

	public function getItems(): array
	{
		return $this->items;
	}

	/**
	 * @param MenuItemDto[] $items
	 * @param string $currentPath
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

	/**
	 * @param MenuItemDto[] $menuItems
	 * @param callable 		$sortFunc
	 * @return void
	 */
	private function sortMenu(array $menuItems, callable $sortFunc): void
	{
		foreach ($menuItems as $menuItem) {
			if ($children = $menuItem->getChildren()) {
				$menuItem->sortChildren($sortFunc);
				$this->sortMenu($children, $sortFunc);
			}
		}
	}

	private function getSortFunc(): callable
	{
		return function (MenuItemDto $aDto, MenuItemDto $bDto) {
			return $aDto->getOrder() > $bDto->getOrder();
		};
	}
}