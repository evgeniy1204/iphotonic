<?php

namespace App\Controller\Admin;

use App\Constants;
use App\Entity\Event;
use App\Field\TinyMCEField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class EventCrudController extends AbstractCrudController
{
	public function __construct(#[Autowire('%env(TINY_MCE_JS_URL)%')] private readonly string $tinyMceJsUrl)
	{
	}

    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title')
				->setRequired(true),
            TextField::new('slug')->setRequired(true),
			ImageField::new('preview')
				->setRequired(true)
				->setBasePath(Constants::ADMIN_ROOT_READ_IMAGES_DIR . Event::PREVIEW_IMAGE_FOLDER)
				->setUploadDir(Constants::ADMIN_ROOT_UPLOADS_DIR . Event::PREVIEW_IMAGE_FOLDER)
				->setRequired(false),
			TextareaField::new('summary')->hideOnIndex(),
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
			TinyMCEField::new('text')->hideOnIndex()->addJsFiles($this->tinyMceJsUrl),
			BooleanField::new('active')
        ];
    }
}
