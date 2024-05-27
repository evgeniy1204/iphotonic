<?php

namespace App\Controller\Admin;

use App\Constants;
use App\Entity\Product;
use App\Field\TinyMCEField;
use App\Repository\ProductCategoryRepository;
use App\Repository\TechnologyRepository;
use App\Trait\SeoFieldsTrait;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
	use SeoFieldsTrait;

	public static function getEntityFqcn(): string
	{
		return Product::class;
	}

	public function configureFields(string $pageName): iterable
	{
		return [
			FormField::addTab('General fields'),
			AssociationField::new('category')->setRequired(true),
			IntegerField::new('menuOrder')->setRequired(true),
			TextField::new('name')->setRequired(true),
			TextField::new('slug')->setRequired(true),
			TextareaField::new('summary')->hideOnIndex(),
			ImageField::new('images')
				->hideOnIndex()
				->setBasePath(Constants::ADMIN_ROOT_READ_IMAGES_DIR . Product::PRODUCT_FILES_FOLDER)
				->setUploadDir(Constants::ADMIN_ROOT_UPLOADS_DIR . Product::PRODUCT_FILES_FOLDER)
				->setFormTypeOption('multiple', true)
				->setRequired(false),
			ImageField::new('files')
				->setBasePath(Constants::ADMIN_ROOT_READ_IMAGES_DIR . Product::PRODUCT_FILES_FOLDER)
				->setUploadDir(Constants::ADMIN_ROOT_UPLOADS_DIR . Product::PRODUCT_FILES_FOLDER)
				->setFormTypeOption('multiple', true)
				->setRequired(false)
				->hideOnIndex(),
			TinyMCEField::new('text')->hideOnIndex(),
			AssociationField::new('relationProducts')->hideOnIndex(),
			AssociationField::new('technology')->setFormTypeOptions(
				[
					'query_builder' => function (TechnologyRepository $technologyRepository) {
						return $technologyRepository->createQueryBuilder('Technology')
							->andWhere('Technology.children IS EMPTY');
					}
				]
			)->hideOnIndex(),
			BooleanField::new('active'),
			BooleanField::new('showOnMainPage'),
			...$this->getSeoFields(),
		];
	}
}
