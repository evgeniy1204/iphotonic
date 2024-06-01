<?php

declare(strict_types=1);

namespace App\Service\Menu;

use App\Dto\MenuItemCollection;
use App\Dto\MenuItemDto;
use App\Entity\Technology;
use App\Repository\TechnologyRepository;
use App\Service\UrlGenerator;

readonly class TechnologyCategoryMenuProvider
{
	public function __construct(
		private TechnologyRepository $technologyRepository,
		private UrlGenerator $urlGenerator
	) {
	}

	public function provide(int $dept, ?Technology $technology = null): MenuItemCollection
	{
		$technologyCategories = $this->technologyRepository->findBy(['parent' => $technology]);
		$menuItems = [];
		$sortFunc = function (MenuItemDto $aDto, MenuItemDto $bDto) {
			return $aDto->getOrder() > $bDto->getOrder();
		};

		foreach ($technologyCategories as $technologyCategory) {
			$item = new MenuItemDto($technologyCategory->getName(), $this->urlGenerator->generateTechnologyUrl($technologyCategory), $technologyCategory->getMenuOrder());
			$menuItems[] = $item;

			$this->generateMenu($dept, $technologyCategory, $item);

			usort($menuItems, $sortFunc);

			$this->sortMenu($menuItems, $sortFunc);

		}

		return new MenuItemCollection($menuItems);
	}


	private function generateMenu(int $dept, Technology $technology, MenuItemDto $parent, int $currentStep = 0): void
	{
		$currentStep++;
		if ($currentStep === $dept) {
			return;
		}
		foreach ($technology->getChildren() as $child) {
			$item = new MenuItemDto($child->getName(), $this->urlGenerator->generateTechnologyUrl($child), $child->getMenuOrder());
			$parent->addChild($item);
			$this->generateMenu($dept, $child, $item, $currentStep);
		}
	}

	/**
	 * @param MenuItemDto[] $menuItems
	 * @param callable $func
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
}