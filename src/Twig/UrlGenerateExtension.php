<?php

declare(strict_types=1);

namespace App\Twig;

use App\Dto\FooterContactsDto;
use App\Entity\News;
use App\Entity\Product;
use App\Service\MenuProvider\ProductCategoryMenuProvider;
use App\Service\MenuProvider\TechnologyCategoryMenuProvider;
use App\Service\SettingsProvider;
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
			new TwigFunction('generate_news_url', [$this, 'generateNewsUrl'])
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
}