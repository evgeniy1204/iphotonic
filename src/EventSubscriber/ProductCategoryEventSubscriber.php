<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Entity\ProductCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGeneratorInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class ProductCategoryEventSubscriber implements EventSubscriberInterface
{
	public function __construct(
		private readonly RequestStack $requestStack
	) {
	}

	public static function getSubscribedEvents(): array
	{
		return [
			BeforeEntityDeletedEvent::class => 'onEntityDeleted',
		];
	}

	public function onEntityDeleted(BeforeEntityDeletedEvent $beforeEntityDeletedEvent): void
	{
		$entity = $beforeEntityDeletedEvent->getEntityInstance();

		if ($entity instanceof ProductCategory) {
			if ($entity->getChildren()) {
				$session = $this->requestStack->getSession();
				$session->getFlashBag()->add('notice', 'test');
				//dump($this->requestStack->getCurrentRequest()->getRequestUri());
				//$item = MenuItem::linkToCrud('', '', $entity::class);
				//$beforeEntityDeletedEvent->setResponse(new RedirectResponse($this->requestStack->getCurrentRequest()->getRequestUri()));
			}
		}
	}
}