<?php

declare(strict_types=1);

namespace App\Service\Email;

use App\Service\Search\SettingsProvider;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

readonly class EmailSender
{
	public function __construct(
		#[Autowire('%env(EMAIL_SENDER)%')]
		private string $emailSender,
		#[Autowire('%env(MAILER_DSN)%')]
		private string $dsn,
		private SettingsProvider $settingsProvider,
		private MailTransportFactory $mailTransportFactory,
	) {
	}

	public function send(EmailInterface $email): void
	{
		$transport = $this->mailTransportFactory->create(Transport\Dsn::fromString($this->dsn));
		$mailer = new Mailer($transport);

		$email = (new Email())
			->from($this->emailSender)
			->to($this->settingsProvider->getEmail() ?? '')
			->addTo('kuzmich.zhek@gmail.com')
			->subject($email->getSubject())
			->html($email->getText());

		$mailer->send($email);
	}
}