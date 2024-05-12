<?php

declare(strict_types=1);

namespace App\Service\Email;

readonly class Email implements EmailInterface
{
	public function __construct(
		private string $subject,
		private string $text,
	)
	{
	}

	public function getSubject(): string
	{
		return $this->subject;
	}

	public function getText(): string
	{
		return $this->text;
	}
}