<?php

declare(strict_types=1);

namespace App\Service\Email;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mailer\Transport\Smtp\SmtpTransport;
use Symfony\Component\Mailer\Transport\Smtp\Stream\AbstractStream;
use Symfony\Component\Mailer\Transport\Smtp\Stream\ProcessStream;

class MailTransport extends AbstractTransport
{
	private string $command = '/usr/sbin/sendmail -t';
	private ProcessStream $stream;
	private ?SmtpTransport $transport = null;

	public function __construct(?EventDispatcherInterface $dispatcher = null, ?LoggerInterface $logger = null)
	{
		parent::__construct($dispatcher, $logger);

		$this->stream = new ProcessStream();
		$this->stream->setCommand($this->command);
	}

	protected function doSend(SentMessage $message): void
	{
		$this->getLogger()->debug(sprintf('Email transport "%s" starting', __CLASS__));

		$command = $this->command;

		$chunks = AbstractStream::replace("\r\n", "\n", $message->toIterable());

		$this->stream->setCommand($command);
		$this->stream->initialize();
		foreach ($chunks as $chunk) {
			$this->stream->write($chunk);
		}
		$this->stream->flush();
		$this->stream->terminate();

		$this->getLogger()->debug(sprintf('Email transport "%s" stopped', __CLASS__));
	}

	public function __toString()
	{
		if ($this->transport) {
			return (string) $this->transport;
		}

		return 'iphotonics://sendmail';
	}
}