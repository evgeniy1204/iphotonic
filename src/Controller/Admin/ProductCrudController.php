<?php

namespace App\Controller\Admin;

use App\Constants;
use App\Entity\Product;
use App\Field\TinyMCEField;
use App\Repository\ProductCategoryRepository;
use App\SeoFieldsTrait;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
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
			TextField::new('name'),
			ImageField::new('images')
				->setBasePath(Constants::ADMIN_ROOT_READ_IMAGES_DIR . Product::PRODUCT_IMAGES_FOLDER)
				->setUploadDir(Constants::ADMIN_ROOT_UPLOADS_DIR . Product::PRODUCT_IMAGES_FOLDER)
				->setFormTypeOption('multiple', true)
				->setRequired(false),
			TinyMCEField::new('text')->hideOnIndex(),
			AssociationField::new('technologies')->hideOnIndex(),
			ArrayField::new('technologies')->hideOnForm(),
			AssociationField::new('applications')->hideOnIndex(),
			ArrayField::new('applications')->hideOnForm(),
			AssociationField::new('category')->setFormTypeOptions(
				[
					'query_builder' => function (ProductCategoryRepository $productCategoryRepository) {
						return $productCategoryRepository->createQueryBuilder('pc')
							->andWhere('pc.children IS EMPTY');
					}
				]
			)->setRequired(true),
			...$this->getSeoFields(),
		];
	}
}
