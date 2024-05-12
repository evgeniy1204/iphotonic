<?php

namespace App\Controller\Admin;

use App\Constants;
use App\Entity\Membership;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class MembershipCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Membership::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            UrlField::new('url')
				->setRequired(true),
			ImageField::new('logo')
				->setRequired(true)
				->setBasePath(Constants::ADMIN_ROOT_READ_IMAGES_DIR . Membership::MEMBERSHIP_IMAGES_FOLDER)
				->setUploadDir(Constants::ADMIN_ROOT_UPLOADS_DIR . Membership::MEMBERSHIP_IMAGES_FOLDER)
				->setRequired(false)
				->setCustomOption('show_preview', true),
        ];
    }
}
