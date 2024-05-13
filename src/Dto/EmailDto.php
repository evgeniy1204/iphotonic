<?php

declare(strict_types=1);

namespace App\Dto;

readonly class EmailDto
{
	public function __construct(
		private string $name,
		private string $email,
		private string $text
	) {
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getText(): string
	{
		return $this->text;
	}
}