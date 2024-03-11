<?php

namespace App\Controller\Admin;

use App\Entity\Technology;
use App\Entity\TechnologyCategory;
use App\Repository\TechnologyCategoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TechnologyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Technology::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextEditorField::new('text'),
            AssociationField::new('category')->setFormTypeOptions(
                [
                    'query_builder' => function (TechnologyCategoryRepository $technologyCategoryRepository) {
                        return $technologyCategoryRepository->createQueryBuilder('tc')
                            ->andWhere('tc.children IS EMPTY');
                    }
                ]
            )->setRequired(true)
        ];
    }
}
