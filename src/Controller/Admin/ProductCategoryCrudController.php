<?php

namespace App\Controller\Admin;

use App\Entity\ProductCategory;
use App\Repository\ProductCategoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCategoryCrudController extends AbstractCrudController
{
    public function __construct()
    {}

    public static function getEntityFqcn(): string
    {
        return ProductCategory::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $id = $this->getContext()->getEntity()->getInstance()?->getId();

        return [
            TextField::new('name'),
            AssociationField::new('parent'),
            AssociationField::new('children')
                ->setFormTypeOptions(
                [
                    'query_builder' => function (ProductCategoryRepository $repo) use ($id) {
                        return $repo->createQueryBuilder('pc')
                            ->andWhere('pc.parent IS NULL')
                            ->orWhere("pc.parent = :parent_id")
                            ->setParameter("parent_id", $id);
                    },
                    'by_reference' => false
                ]
            ),
        ];
    }
}
