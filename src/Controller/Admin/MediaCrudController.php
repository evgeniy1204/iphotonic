<?php

namespace App\Controller\Admin;

use App\Constants;
use App\Entity\Media;
use App\Field\TinyMCEField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class MediaCrudController extends AbstractCrudController
{
	public function __construct(#[Autowire('%env(TINY_MCE_JS_URL)%')] private readonly string $tinyMceJsUrl)
	{
	}

    public static function getEntityFqcn(): string
    {
        return Media::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title')
				->setRequired(true),
            TextField::new('slug')
				->setRequired(true),
			ImageField::new('preview')
				->setRequired(true)
				->setBasePath(Constants::ADMIN_ROOT_READ_IMAGES_DIR . Media::PREVIEW_IMAGE_FOLDER)
				->setUploadDir(Constants::ADMIN_ROOT_UPLOADS_DIR . Media::PREVIEW_IMAGE_FOLDER),
            DateTimeField::new('createdAt')
				->setFormat(DateTimeField::FORMAT_MEDIUM)
                ->setTimezone($this->getParameter('app.timezone_id')),
			TinyMCEField::new('description')
                ->hideOnIndex()
				->addJsFiles($this->tinyMceJsUrl),
			BooleanField::new('active')
        ];
    }
}
