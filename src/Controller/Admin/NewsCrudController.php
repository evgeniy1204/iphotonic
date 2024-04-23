<?php

namespace App\Controller\Admin;

use App\Constants;
use App\Entity\News;
use App\Field\TinyMCEField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
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
            TextField::new('title'),
            TextField::new('slug'),
			ImageField::new('preview')
				->setBasePath(Constants::ADMIN_ROOT_READ_IMAGES_DIR . News::PREVIEW_IMAGE_FOLDER)
				->setUploadDir(Constants::ADMIN_ROOT_UPLOADS_DIR . News::PREVIEW_IMAGE_FOLDER),
            DateTimeField::new('createdAt')
                ->setTimezone($this->getParameter('app.timezone_id'))
                ->hideOnForm(),
			TinyMCEField::new('text')
                ->setRequired(true)
                ->hideOnIndex(),
			BooleanField::new('active')
        ];
    }
}
