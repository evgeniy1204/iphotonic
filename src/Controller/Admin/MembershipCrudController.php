<?php

namespace App\Controller\Admin;

use App\Entity\Membership;
use App\Field\TinyMCEField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MembershipCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Membership::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TinyMCEField::new('description')->hideOnIndex(),
            ImageField::new('logo')
                ->setBasePath(Membership::MEMBERSHIPS_BASE_PATH)
                ->setUploadDir('public/' . Membership::MEMBERSHIPS_BASE_PATH)
        ];
    }
}
