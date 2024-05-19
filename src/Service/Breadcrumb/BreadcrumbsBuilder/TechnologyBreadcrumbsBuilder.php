<?php

declare(strict_types=1);

namespace App\Service\Breadcrumb\BreadcrumbsBuilder;

use App\Dto\BreadcrumbDto;
use App\Entity\Technology;
use App\Service\Breadcrumb\BreadcrumbAwareInterface;
use App\Service\Breadcrumb\BreadcrumbsBuilderInterface;
use App\Service\UrlGenerator;

readonly class TechnologyBreadcrumbsBuilder implements BreadcrumbsBuilderInterface
{
	public function __construct(private UrlGenerator $urlGenerator)
	{
	}

	/**
	 * @param BreadcrumbAwareInterface|Technology $breadcrumbAware
	 * @return BreadcrumbDto[]
	 */
	public function build(BreadcrumbAwareInterface|Technology $breadcrumbAware): array
	{
		$breadcrumbs = [];
		$this->generateBreadcrumbs($breadcrumbs, $breadcrumbAware->getParent());
		$breadcrumbs[] = new BreadcrumbDto(
			'Technologies',
			$this->urlGenerator->generateTechnologyLandingUrl(),
		);

		return array_reverse($breadcrumbs);
	}

	public function isSupport(BreadcrumbAwareInterface $breadcrumbAware): bool
	{
		return $breadcrumbAware instanceof Technology;
	}

	private function generateBreadcrumbs(array &$breadcrumbs, ?Technology $technology): void
	{
		if (!$technology) {
			return;
		}
		$breadcrumbs[] = new BreadcrumbDto(
			$technology->getName(),
			$this->urlGenerator->generateTechnologyUrl($technology)
		);
		$this->generateBreadcrumbs($breadcrumbs, $technology->getParent());
	}
}