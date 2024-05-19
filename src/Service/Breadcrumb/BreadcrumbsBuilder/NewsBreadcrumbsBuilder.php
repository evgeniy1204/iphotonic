<?php

declare(strict_types=1);

namespace App\Service\Breadcrumb\BreadcrumbsBuilder;

use App\Dto\BreadcrumbDto;
use App\Entity\News;
use App\Service\Breadcrumb\BreadcrumbAwareInterface;
use App\Service\Breadcrumb\BreadcrumbsBuilderInterface;
use App\Service\UrlGenerator;

readonly class NewsBreadcrumbsBuilder implements BreadcrumbsBuilderInterface
{
	public function __construct(private UrlGenerator $urlGenerator)
	{
	}

	/**
	 * @param BreadcrumbAwareInterface|News $breadcrumbAware
	 * @return BreadcrumbDto[]
	 */
	public function build(BreadcrumbAwareInterface|News $breadcrumbAware): array
	{
		$breadcrumbs = [];
		$breadcrumbs[] = new BreadcrumbDto(
			'Media center',
			$this->urlGenerator->generateMediaCenterLandingUrl(),
		);
		$breadcrumbs[] = new BreadcrumbDto(
			'Company news',
			$this->urlGenerator->generateNewsLandingUrl(),
		);

		return $breadcrumbs;
	}

	public function isSupport(BreadcrumbAwareInterface $breadcrumbAware): bool
	{
		return $breadcrumbAware instanceof News;
	}
}