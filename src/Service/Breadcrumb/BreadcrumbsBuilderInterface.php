<?php

namespace App\Service\Breadcrumb;

use App\Dto\BreadcrumbDto;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(self::BREADCRUMB_BUILDER_TAG)]
interface BreadcrumbsBuilderInterface
{
	public const BREADCRUMB_BUILDER_TAG = 'breadcrumb_builder';

	/**
	 * @return BreadcrumbDto[]
	 */
	public function build(BreadcrumbAwareInterface $breadcrumbAware): array;

	public function isSupport(BreadcrumbAwareInterface $breadcrumbAware): bool;
}