<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\CountryRequestResult;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Sypex\Geo;

class CountryRequestResolver
{
	public function __construct(
		#[Autowire('%env(IP_COUNTRIES_DB)%')] private string $sxGeoDbFile,
		#[Autowire('%env(ALLOWED_COUNTRIES)%')] private string $allowedCountries,
	) {
	}

	public function resolveCountryByRequest(Request $request): ?CountryRequestResult
	{
		$ip = $request->getClientIp();
		if ($ip && $this->sxGeoDbFile) {
			$geo = new Geo($this->sxGeoDbFile);

			return new CountryRequestResult(explode(',', $this->allowedCountries), $geo->getCountry($request->getClientIp()));
		}

		return new CountryRequestResult(explode(',', $this->allowedCountries), null);
	}
}