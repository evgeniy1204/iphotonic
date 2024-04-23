<?php

namespace App\Controller\Admin;

use App\Constants;
use App\Entity\Technology;
use App\Field\TinyMCEField;
use App\Repository\TechnologyCategoryRepository;
use App\SeoFieldsTrait;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TechnologyCrudController extends AbstractCrudController
{
	use SeoFieldsTrait;

    public static function getEntityFqcn(): string
    {
        return Technology::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
			FormField::addTab('General fields'),
            TextField::new('name'),
			TextField::new('slug'),
			AssociationField::new('parent'),
			ImageField::new('images')
				->setLabel('Image')
				->hideOnIndex()
				->setBasePath(Constants::ADMIN_ROOT_READ_IMAGES_DIR . Technology::TECHNOLOGY_IMAGES_FOLDER)
				->setUploadDir(Constants::ADMIN_ROOT_UPLOADS_DIR . Technology::TECHNOLOGY_IMAGES_FOLDER),
			TinyMCEField::new('text')->hideOnIndex(),
			BooleanField::new('active'),
			...$this->getSeoFields(),
        ];
    }
}
