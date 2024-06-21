<?php

declare(strict_types=1);

namespace App\Service\Email;

use App\Service\Search\SettingsProvider;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class EmailSender
{
	public function __construct(
		private MailerInterface $mailer,
		#[Autowire('%env(EMAIL_SENDER)%')]
		private string $emailSender,
		private SettingsProvider $settingsProvider,
	) {
	}

	public function send(EmailInterface $email): void
	{
		$email = (new Email())
			->from($this->emailSender)
			->to('kuzmich.zhek@gmail.com')
			->subject($email->getSubject())
			->html($email->getText());

		$this->mailer->send($email);
	}
}