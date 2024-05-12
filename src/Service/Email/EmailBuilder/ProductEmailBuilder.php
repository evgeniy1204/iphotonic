<?php

declare(strict_types=1);

namespace App\Service\Email\EmailBuilder;

use App\Dto\Email\EmailDto;
use App\Service\Email\Email;
use App\Service\Email\EmailInterface;
use Twig\Environment;

readonly class ProductEmailBuilder
{
	public function __construct(private Environment $twig)
	{
	}

	public function buildEmail(EmailDto $emailDto): EmailInterface
	{
		return new Email(
			'Product message',
			$this->twig->render('email/product_email.html.twig', ['email' => $emailDto])
		);
	}
}