<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Repository\ProductCategoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextEditorField::new('text'),
            AssociationField::new('technologies')->hideOnIndex(),
            ArrayField::new('technologies')->hideOnForm(),
            AssociationField::new('applications')->hideOnIndex(),
            ArrayField::new('applications')->hideOnForm(),
            AssociationField::new('categories')->setFormTypeOptions(
                [
                    'query_builder' => function (ProductCategoryRepository $productCategoryRepository) {
                        return $productCategoryRepository->createQueryBuilder('pc')
                            ->andWhere('pc.children IS EMPTY');
                    }
                ]
            )->hideOnIndex(),
            ArrayField::new('categories')->hideOnForm(),

        ];
    }
}
