<?php

namespace App\Controller\Admin;

use App\Constants;
use App\Entity\Download;
use App\Trait\SeoFieldsTrait;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DownloadCrudController extends AbstractCrudController
{
	use SeoFieldsTrait;

    public static function getEntityFqcn(): string
    {
        return Download::class;
    }

    public function configureFields(string $pageName): iterable
    {
		return [
			FormField::addTab('General fields'),
            TextField::new('fileName'),
			ImageField::new('preview')
				->setRequired(false)
				->setBasePath(Constants::ADMIN_ROOT_READ_IMAGES_DIR . Download::DOWNLOAD_PREVIEW_FILE_FOLDER_PATH)
				->setUploadDir(Constants::ADMIN_ROOT_UPLOADS_DIR . Download::DOWNLOAD_PREVIEW_FILE_FOLDER_PATH),
			ImageField::new('file')
				->hideOnIndex()
				->setRequired(false)
				->setBasePath(Constants::ADMIN_ROOT_READ_IMAGES_DIR . Download::DOWNLOAD_FILE_FOLDER_PATH)
				->setUploadDir(Constants::ADMIN_ROOT_UPLOADS_DIR . Download::DOWNLOAD_FILE_FOLDER_PATH),
			...$this->getSeoFields(),
		];
    }
}
