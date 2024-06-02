<?php

declare(strict_types=1);

namespace App\Service\Menu;

use App\Dto\MenuItemCollection;
use App\Dto\MenuItemDto;
use App\Entity\Technology;
use App\Repository\TechnologyRepository;
use App\Service\UrlGenerator;
use Symfony\Component\HttpFoundation\RequestStack;

readonly class TechnologyCategoryMenuProvider
{
	public function __construct(
		private TechnologyRepository $technologyRepository,
		private UrlGenerator         $urlGenerator,
		private RequestStack         $requestStack
	)
	{
	}

	public function provide(int $dept, ?Technology $technology = null): MenuItemCollection
	{
		$technologyCategories = $this->technologyRepository->findBy(['parent' => $technology]);
		$menuItems = [];

		foreach ($technologyCategories as $technologyCategory) {
			$item = new MenuItemDto($technologyCategory->getName(), $this->urlGenerator->generateTechnologyUrl($technologyCategory), $technologyCategory->getMenuOrder());
			$menuItems[] = $item;

			$this->generateMenu($dept, $technologyCategory, $item);
		}

		return new MenuItemCollection($this->getCurrentPath(), $menuItems);
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

	private function getCurrentPath(): string
	{
		$currentRequest = $this->requestStack->getCurrentRequest();

		return $currentRequest->getPathInfo();
	}
}