<?php

namespace App\Controller\Admin;

use App\Entity\TechnologyCategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TechnologyCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TechnologyCategory::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            AssociationField::new('parent')
        ];
    }
}
