<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\News;
use App\Entity\Product;
use App\Entity\Technology;
use App\Service\UrlGenerator;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

#[AutoconfigureTag('twig.extension')]
class UrlGenerateExtension extends AbstractExtension
{
	public function __construct(
		private readonly UrlGenerator $urlGenerator,
	) {
	}

	/**
	 * @return TwigFunction[]
	 */
	public function getFunctions(): array
	{
		return [
			new TwigFunction('generate_product_url', [$this, 'generateProductUrl']),
			new TwigFunction('generate_news_url', [$this, 'generateNewsUrl']),
			new TwigFunction('generate_technology_url', [$this, 'generateTechnologyUrl'])
		];
	}

	public function generateProductUrl(Product $product): string
	{
		return $this->urlGenerator->generateProductUrl($product);
	}

	public function generateNewsUrl(News $news): string
	{
		return $this->urlGenerator->generateNewsUrl($news);
	}

	public function generateTechnologyUrl(Technology $technology): string
	{
		return $this->urlGenerator->generateTechnologyUrl($technology);
	}
}