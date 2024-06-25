<?php

declare(strict_types=1);

namespace App\Service\Email;

use Symfony\Component\Validator\Constraints as Assert;

class EmailRequest
{
	#[
		Assert\NotBlank,
		Assert\NotNull,
	]
	public string $name;

	#[
		Assert\NotBlank,
		Assert\NotNull,
		Assert\Email,
	]
	public string $email;

	#[
		Assert\NotBlank,
		Assert\NotNull,
	]
	public string $message;

	public string $product;

	public ?string $check;
}