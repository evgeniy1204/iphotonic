<?php

namespace App\Controller\Admin;

use App\Constants;
use App\Entity\Application;
use App\Field\TinyMCEField;
use App\Trait\SeoFieldsTrait;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ApplicationCrudController extends AbstractCrudController
{
	use SeoFieldsTrait;

    public static function getEntityFqcn(): string
    {
        return Application::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
			FormField::addTab('General fields'),
            TextField::new('name')->setRequired(true),
			ImageField::new('preview')
				->setBasePath(Constants::ADMIN_ROOT_READ_IMAGES_DIR . Application::APPLICATION_IMAGE_FOLDER)
				->setUploadDir(Constants::ADMIN_ROOT_UPLOADS_DIR . Application::APPLICATION_IMAGE_FOLDER)
				->hideOnIndex(),
            TinyMCEField::new('text')->hideOnIndex(),
			...$this->getSeoFields(),
        ];
    }
}
