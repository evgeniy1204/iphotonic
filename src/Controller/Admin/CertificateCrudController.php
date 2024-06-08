<?php

namespace App\Controller\Admin;

use App\Constants;
use App\Entity\Certificate;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CertificateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Certificate::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('url'),
            ImageField::new('logo')
                ->setBasePath(Constants::ADMIN_ROOT_READ_IMAGES_DIR . Certificate::CERTIFICATE_FOLDER)
                ->setUploadDir(Constants::ADMIN_ROOT_UPLOADS_DIR . Certificate::CERTIFICATE_FOLDER),
        ];
    }
}
