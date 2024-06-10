<?php

declare(strict_types=1);

namespace App\Dto;

readonly class CountryRequestResult
{
	public function __construct(
		private array $allowedCountries,
		private ?string $countryIsoCode
	) {
	}

	public function isAllowed(): bool
	{
		if (!$this->countryIsoCode || !array_filter($this->allowedCountries)) {
			return true;
		}

		return in_array($this->countryIsoCode, $this->allowedCountries);
	}
}