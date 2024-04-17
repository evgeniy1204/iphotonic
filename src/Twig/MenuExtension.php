<?php

declare(strict_types=1);

namespace App\Twig;

use App\Service\MenuProvider;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

#[AutoconfigureTag('twig.extension')]
class MenuExtension extends AbstractExtension
{
	private const DEFAULT_MENU_DEPT = 1;

	public function __construct(
		private readonly MenuProvider $menuProvider,
	) {
	}

	/**
	 * @return TwigFunction[]
	 */
	public function getFunctions(): array
	{
		return [
			new TwigFunction('generate_menu', [$this, 'generateMenu']),
		];
	}

	public function generateMenu(int $dept = self::DEFAULT_MENU_DEPT): array
	{
		return $this->menuProvider->provide($dept);
	}
}