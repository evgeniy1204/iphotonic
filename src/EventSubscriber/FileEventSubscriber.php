<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Entity\File;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityDeletedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Filesystem\Filesystem;

readonly class FileEventSubscriber implements EventSubscriberInterface
{
	public function __construct(private Filesystem $filesystem)
	{
	}

	public static function getSubscribedEvents(): array
	{
		return [
			AfterEntityDeletedEvent::class => 'onFileDelete'
		];
	}

	public function onFileDelete(AfterEntityDeletedEvent $deletedEvent): void
	{
		$file = $deletedEvent->getEntityInstance();
		if (!$file instanceof File) {
			return;
		}
		$this->filesystem->remove($file->getOriginalFullPath());
	}
}