<?php

declare(strict_types=1);

namespace App\Service\Email;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

readonly class EmailSender
{
	public function __construct(
		private MailerInterface $mailer,
		#[Autowire('%env(EMAIL_SENDER)%')]
		private string $emailSender,
		#[Autowire('%env(EMAIL_RECEIVER)%')]
		private string $emailReceivers
	) {
	}

	public function send(EmailInterface $email): void
	{
		$receivers = [];
		foreach (explode(',', $this->emailReceivers) as $emailReceiver) {
			$receivers[] = new Address($emailReceiver);
		}
		$email = (new Email())
			->from($this->emailSender)
			->to(...$receivers)
			->subject($email->getSubject())
			->html($email->getText());

		$this->mailer->send($email);
	}
}