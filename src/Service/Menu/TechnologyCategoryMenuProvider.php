<?php

declare(strict_types=1);

namespace App\Service\Menu;

use App\Dto\MenuItemDto;
use App\Entity\Technology;
use App\Repository\TechnologyRepository;

readonly class TechnologyCategoryMenuProvider
{
	public function __construct(private TechnologyRepository $technologyRepository)
	{
	}

	/**
	 * @return MenuItemDto[]
	 */
	public function provide(int $dept): array
	{
		$technologyCategories = $this->technologyRepository->findBy(['parent' => null]);
		$menuItems = [];

		foreach ($technologyCategories as $technologyCategory) {
			$item = new MenuItemDto($technologyCategory->getName(), (string) $technologyCategory->getId());
			$menuItems[] = $item;

			$this->generateMenu($dept, $technologyCategory, $item);
		}

		return $menuItems;
	}


	private function generateMenu(int $dept, Technology $technology, MenuItemDto $parent, int $currentStep = 0): void
	{
		$currentStep++;
		if ($currentStep === $dept) {
			return;
		}
		foreach ($technology->getChildren() as $child) {
			$item = new MenuItemDto($child->getName(), (string) $child->getId());
			$parent->addChild($item);
			$this->generateMenu($dept, $child, $item, $currentStep);
		}
	}
}