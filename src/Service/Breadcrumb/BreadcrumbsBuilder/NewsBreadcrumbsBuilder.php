<?php

declare(strict_types=1);

namespace App\Service\Breadcrumb\BreadcrumbsBuilder;

use App\Dto\BreadcrumbDto;
use App\Service\UrlGenerator;

readonly class NewsBreadcrumbsBuilder
{
	public function __construct(private UrlGenerator $urlGenerator)
	{
	}

	/**
	 * @return BreadcrumbDto[]
	 */
	public function build(): array
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
}