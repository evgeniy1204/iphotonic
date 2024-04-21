<?php

namespace App\Controller\Admin;

use App\Entity\ProductCategory;
use App\Field\TinyMCEField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductCategory::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TinyMCEField::new('summary')
				->setRequired(false),
			AssociationField::new('equipments'),
            TinyMCEField::new('description')
				->setRequired(false),
			AssociationField::new('technology')
				->setLabel('Technology'),
            AssociationField::new('parent')
				->setLabel('Parent category'),
        ];
    }
}
