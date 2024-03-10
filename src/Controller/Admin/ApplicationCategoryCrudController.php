<?php

namespace App\Controller\Admin;

use App\Entity\ApplicationCategory;
use App\Repository\ApplicationCategoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ApplicationCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ApplicationCategory::class;
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
                        'query_builder' => function (ApplicationCategoryRepository $applicationCategoryRepository) use ($id) {
                            return $applicationCategoryRepository->createQueryBuilder('ac')
                                ->andWhere('ac.id != :parent_id')
                                ->andWhere('ac.parent IS NULL')
                                ->orWhere('ac.parent = :parent_id')
                                ->setParameter("parent_id", $id);
                        },
                        'by_reference' => false
                    ]
                )
                ->hideOnIndex(),
            ArrayField::new('children')->hideOnForm()
        ];
    }
}
