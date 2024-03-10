<?php

namespace App\Controller\Admin;

use App\Entity\TechnologyCategory;
use App\Repository\TechnologyCategoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TechnologyCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TechnologyCategory::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $id = $this->getContext()->getEntity()->getInstance()?->getId();

        return [
            TextField::new('name'),
            AssociationField::new('parent')->hideOnForm(),
            AssociationField::new('children')
                ->setFormTypeOptions(
                    [
                        'query_builder' => function (TechnologyCategoryRepository $technologyCategoryRepository) use ($id) {
                            return $technologyCategoryRepository->createQueryBuilder('tc')
                                ->andWhere('tc.id != :parent_id')
                                ->andWhere('tc.parent IS NULL')
                                ->orWhere('tc.parent = :parent_id')
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
