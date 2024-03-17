<?php

namespace App\Controller\Admin;

use App\Constants;
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
                ->setBasePath(Constants::ADMIN_ROOT_READ_IMAGES_DIR . Membership::MEMBERSHIPS_FOLDER)
                ->setUploadDir(Constants::ADMIN_ROOT_UPLOADS_DIR . Membership::MEMBERSHIPS_FOLDER)
        ];
    }
}
