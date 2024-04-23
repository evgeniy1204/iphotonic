<?php

declare(strict_types=1);

namespace App\Service\MenuProvider;

use App\Dto\MenuItem;
use App\Entity\TechnologyCategory;
use App\Repository\TechnologyCategoryRepository;
use App\Repository\TechnologyRepository;

readonly class TechnologyCategoryMenuProvider
{
	public function __construct(private TechnologyRepository $technologyRepository)
	{
	}

	/**
	 * @return MenuItem[]
	 */
	public function provide(int $dept): array
	{
		$technologyCategories = $this->technologyRepository->findBy(['parent' => null]);
		$menuItems = [];

		foreach ($technologyCategories as $technologyCategory) {
			$item = new MenuItem($technologyCategory->getName(), (string) $technologyCategory->getId());
			$menuItems[] = $item;

			$this->generateMenu($dept, $technologyCategory, $item);
		}

		return $menuItems;
	}


	private function generateMenu(int $dept, TechnologyCategory $technologyCategory, MenuItem $parent, int $currentStep = 0): void
	{
		$currentStep++;
		if ($currentStep === $dept) {
			return;
		}
		foreach ($technologyCategory->getChildren() as $child) {
			$item = new MenuItem($child->getName(), (string) $child->getId());
			$parent->addChild($item);
			$this->generateMenu($dept, $child, $item, $currentStep);
		}
	}
}