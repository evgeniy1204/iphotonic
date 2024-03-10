<?php

namespace App\Controller\Admin;

use App\Entity\Application;
use App\Repository\ApplicationCategoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ApplicationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Application::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextEditorField::new('text'),
            AssociationField::new('categories')->setFormTypeOptions(
                [
                    'query_builder' => function (ApplicationCategoryRepository $applicationCategoryRepository) {
                        return $applicationCategoryRepository->createQueryBuilder('ac')
                            ->andWhere('ac.children IS EMPTY');
                    }
                ]
            )
                ->hideOnIndex(),
            ArrayField::new('categories')->hideOnForm()
        ];
    }
}
