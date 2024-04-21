<?php

namespace App\Controller\Admin;

use App\Constants;
use App\Entity\Partner;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PartnerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Partner::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            ImageField::new('logo')
                ->setBasePath(Constants::ADMIN_ROOT_READ_IMAGES_DIR . Partner::PARTNERS_FOLDER)
                ->setUploadDir(Constants::ADMIN_ROOT_UPLOADS_DIR . Partner::PARTNERS_FOLDER),
			TextEditorField::new('contacts')->hideOnIndex()
        ];
    }
}
