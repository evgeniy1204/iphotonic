<?php

namespace App\Controller\Admin;

use App\Constants;
use App\Entity\Event;
use App\Field\TinyMCEField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title')
				->setRequired(true),
            TextField::new('slug')->hideOnIndex()->setRequired(true),
			ImageField::new('preview')
				->setRequired(true)
				->setBasePath(Constants::ADMIN_ROOT_READ_IMAGES_DIR . Event::PREVIEW_IMAGE_FOLDER)
				->setUploadDir(Constants::ADMIN_ROOT_UPLOADS_DIR . Event::PREVIEW_IMAGE_FOLDER)
				->setRequired(false),
            DateTimeField::new('createdEventStartAt')
				->hideOnIndex()
				->setRequired(true)
                ->setTimezone($this->getParameter('app.timezone_id'))
				->setLabel('Event start'),
            DateTimeField::new('createdEventEndAt')
				->hideOnIndex()
				->setRequired(true)
                ->setTimezone($this->getParameter('app.timezone_id'))
				->setLabel('Event end'),
            DateTimeField::new('createdAt')
				->setRequired(true)
                ->setTimezone($this->getParameter('app.timezone_id')),
			TinyMCEField::new('text')->hideOnIndex(),
			BooleanField::new('active')
        ];
    }
}
