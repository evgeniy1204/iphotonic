<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Service\CountryRequestResolver;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\LockedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

readonly class HandleRequestEventSubscriber implements EventSubscriberInterface
{
	public function __construct(private CountryRequestResolver $requestCountryResolver)
	{
	}

	public static function getSubscribedEvents(): array
	{
		return [
			KernelEvents::REQUEST => 'onRequest',
		];
	}

	public function onRequest(RequestEvent $event): void
	{
		if (!$event->isMainRequest()) {
			return;
		}

		$countryRequestResult = $this->requestCountryResolver?->resolveCountryByRequest($event->getRequest());
		if ($countryRequestResult->isBlocked()) {
			echo 'Page is blocked';
			die;
		}
	}
}