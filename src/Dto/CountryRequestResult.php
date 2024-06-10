<?php

declare(strict_types=1);

namespace App\Dto;

readonly class CountryRequestResult
{
	public function __construct(
		private array   $blockedCountries,
		private ?string $countryIsoCode
	) {
	}

	public function isBlocked(): bool
	{
		if (!$this->countryIsoCode || !array_filter($this->blockedCountries)) {
			return true;
		}

		return in_array($this->countryIsoCode, $this->blockedCountries);
	}
}