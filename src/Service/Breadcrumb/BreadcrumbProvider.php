<?php

declare(strict_types=1);

namespace App\Service\Breadcrumb;

use LogicException;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class BreadcrumbProvider
{
	/**
	 * @param iterable|BreadcrumbsBuilderInterface[] $breadcrumbBuilders
	 */
	public function __construct(
		#[TaggedIterator(tag: BreadcrumbsBuilderInterface::BREADCRUMB_BUILDER_TAG)] private iterable $breadcrumbBuilders
	) {
	}

	public function buildBreadcrumb(BreadcrumbAwareInterface $breadcrumbAware): array
	{
		$builder = $this->getBreadcrumbBuilder($breadcrumbAware);

		return $builder->build($breadcrumbAware);
	}

	private function getBreadcrumbBuilder(BreadcrumbAwareInterface $breadcrumbAware): BreadcrumbsBuilderInterface
	{
		foreach ($this->breadcrumbBuilders as $breadcrumbBuilder) {
			if ($breadcrumbBuilder->isSupport($breadcrumbAware)) {
				return $breadcrumbBuilder;
			}
		}

		throw new LogicException('Not support breadcrumbs');
	}
}