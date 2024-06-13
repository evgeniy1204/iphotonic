<?php

namespace App\Controller\Admin;

use App\Constants;
use App\Entity\ProductCategory;
use App\Field\TinyMCEField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class ProductCategoryCrudController extends AbstractCrudController
{
	public function __construct(#[Autowire('%env(TINY_MCE_JS_URL)%')] private readonly string $tinyMceJsUrl)
	{
	}

    public static function getEntityFqcn(): string
    {
        return ProductCategory::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
			TextField::new('name')->setRequired(true),
			IntegerField::new('menuOrder')->setRequired(true),
			TextField::new('slug')->setRequired(true)
				->hideOnIndex(),
			AssociationField::new('parent')
				->setLabel('Parent category'),
			ImageField::new('previewImage')
				->hideOnIndex()
				->setBasePath(Constants::ADMIN_ROOT_READ_IMAGES_DIR . ProductCategory::PRODUCT_CATEGORY_PREVIEW_FOLDER)
				->setUploadDir(Constants::ADMIN_ROOT_UPLOADS_DIR . ProductCategory::PRODUCT_CATEGORY_PREVIEW_FOLDER)
				->setRequired(false),
			AssociationField::new('technology')
				->setLabel('Technology')
				->hideOnIndex(),
            TinyMCEField::new('summary')
				->setRequired(false)
				->hideOnIndex()
				->addJsFiles($this->tinyMceJsUrl),
			AssociationField::new('equipments')
				->hideOnIndex(),
            TinyMCEField::new('description')
				->setRequired(false)
				->hideOnIndex()
				->addJsFiles($this->tinyMceJsUrl),
        ];
    }
}
