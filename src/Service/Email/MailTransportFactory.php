<?php

declare(strict_types=1);

namespace App\Service\Email;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\Mailer\Transport\AbstractTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;
use Symfony\Component\Mailer\Transport\TransportInterface;

#[AutoconfigureTag('mailer.transport_factory')]
class MailTransportFactory extends AbstractTransportFactory
{
	public function create(Dsn $dsn): TransportInterface
	{
		return new MailTransport($this->dispatcher, $this->logger);
	}

	protected function getSupportedSchemes(): array
	{
		return ['iphotonics'];
	}
}