<?php

declare(strict_types=1);

namespace App\Response;

class TinyResponse
{
	public function __construct(private string $location)
	{
	}

	public function getLocation(): string
	{
		return json_encode(['location' => $this->location]);
	}
}