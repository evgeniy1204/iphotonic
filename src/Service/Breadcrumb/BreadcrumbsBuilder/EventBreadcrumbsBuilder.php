<?php

declare(strict_types=1);

namespace App\Service\Breadcrumb\BreadcrumbsBuilder;

use App\Dto\BreadcrumbDto;
use App\Entity\Event;
use App\Service\Breadcrumb\BreadcrumbAwareInterface;
use App\Service\Breadcrumb\BreadcrumbsBuilderInterface;
use App\Service\UrlGenerator;

readonly class EventBreadcrumbsBuilder implements BreadcrumbsBuilderInterface
{
	public function __construct(private UrlGenerator $urlGenerator)
	{
	}

	/**
	 * @param BreadcrumbAwareInterface|Event $breadcrumbAware
	 * @return BreadcrumbDto[]
	 */
	public function build(BreadcrumbAwareInterface|Event $breadcrumbAware): array
	{
		$breadcrumbs = [];
		$breadcrumbs[] = new BreadcrumbDto(
			'Media center',
			$this->urlGenerator->generateMediaCenterLandingUrl(),
		);
		$breadcrumbs[] = new BreadcrumbDto(
			'Upcoming Events',
			$this->urlGenerator->generateEventLandingUrl(),
		);
		$breadcrumbs[] = new BreadcrumbDto($breadcrumbAware->getTitle());

		return $breadcrumbs;
	}

	public function isSupport(BreadcrumbAwareInterface $breadcrumbAware): bool
	{
		return $breadcrumbAware instanceof Event;
	}
}