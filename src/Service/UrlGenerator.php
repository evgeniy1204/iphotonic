<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Event;
use App\Entity\News;
use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Entity\Technology;
use Symfony\Component\Routing\RouterInterface;

readonly class UrlGenerator
{
	public function __construct(private RouterInterface $router)
	{
	}

	public function generateProductCategoryUrl(ProductCategory $category): string
	{
		$urlParams = $category->getParent() ? [
			'productCategorySlug' => $category->getParent()->getSlug(),
			'productSubCategorySlug' => $category->getSlug()
		] : [
			'productCategorySlug' => $category->getSlug()
		];

		return $this->router->generate('app_product_category', $urlParams);
	}

	public function generateProductUrl(Product $product): string
	{
		$urlParams = [
			'productCategorySlug' => $product->getCategory()->getParent()->getSlug(),
			'productSubCategorySlug' => $product->getCategory()->getSlug(),
			'productSlug' => $product->getSlug(),
		];

		return $this->router->generate('app_product_item', $urlParams);
	}

	public function generateTechnologyUrl(Technology $technology): string
	{
		$urlParams = $technology->getParent() ? [
			'technologyCategorySlug' => $technology->getParent()->getSlug(),
			'technologySubCategorySlug' => $technology->getSlug()
		] : [
			'technologyCategorySlug' => $technology->getSlug()
		];

		return $this->router->generate('app_technology_item', $urlParams);
	}

	public function generateNewsLandingUrl(): string
	{
		return $this->router->generate('app_article_index');
	}

	public function generateNewsUrl(News $news): string
	{
		return $this->router->generate('app_article_item', ['slug' => $news->getSlug()]);
	}

	public function generateEventUrl(Event $event): string
	{
		return $this->router->generate('app_event_item', ['slug' => $event->getSlug()]);
	}

	public function generateMediaCenterLandingUrl(): string
	{
		return $this->router->generate('app_media_center_index');

	}

	public function generateEventLandingUrl(): string
	{
		return $this->router->generate('app_event_index');
	}

	public function generateMediaLandingUrl(): string
	{
		return $this->router->generate('app_photo_and_video_index');
	}

	public function generateTechnologyLandingUrl(): string
	{
		return $this->router->generate('app_technology_index');
	}
}