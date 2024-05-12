<?php

declare(strict_types=1);

namespace App\Service\Email;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class EmailSender
{
	public function __construct(
		private MailerInterface $mailer,
		#[Autowire('%env(EMAIL_SENDER)%')]
		private string $emailSender,
		#[Autowire('%env(EMAIL_RECEIVER)%')]
		private string $emailReceiver
	) {
	}

	public function send(EmailInterface $email): void
	{
		$email = (new Email())
			->from($this->emailSender)
			->to($this->emailReceiver)
			->subject($email->getSubject())
			->text($email->getText());

		$this->mailer->send($email);
	}
}