<?php

namespace App\Controller\Admin;

use App\Constants;
use App\Entity\News;
use App\Field\TinyMCEField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class NewsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return News::class;
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
				->setBasePath(Constants::ADMIN_ROOT_READ_IMAGES_DIR . News::PREVIEW_IMAGE_FOLDER)
				->setUploadDir(Constants::ADMIN_ROOT_UPLOADS_DIR . News::PREVIEW_IMAGE_FOLDER)
				->setRequired(false),
            DateTimeField::new('createdAt')
				->setRequired(true)
                ->setTimezone($this->getParameter('app.timezone_id')),
			TextareaField::new('summary')->hideOnIndex(),
			TinyMCEField::new('text')
                ->hideOnIndex(),
			BooleanField::new('active')
        ];
    }
}
