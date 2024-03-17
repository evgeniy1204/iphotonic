<?php

namespace App\Controller\Admin;

use App\Constants;
use App\Entity\Setting;
use App\SeoFieldsTrait;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class SettingCrudController extends AbstractCrudController
{
	use SeoFieldsTrait;

	public static function getEntityFqcn(): string
	{
		return Setting::class;
	}

	public function configureFields(string $pageName): iterable
	{
		return [
			FormField::addTab('Social networks'),
			UrlField::new('linkedIn'),
			UrlField::new('youtube'),
			UrlField::new('instagram'),
			FormField::addTab('Slider'),
			ImageField::new('sliderImages')
				->setBasePath(Constants::ADMIN_ROOT_READ_IMAGES_DIR . Setting::SLIDER_IMAGES_FOLDER)
				->setUploadDir(Constants::ADMIN_ROOT_UPLOADS_DIR . Setting::SLIDER_IMAGES_FOLDER)
				->setFormTypeOption('multiple', true)
				->setRequired(false),
			...$this->getSeoFields(),
		];
	}

	public function configureActions(Actions $actions): Actions
	{
		return $actions->disable(Action::NEW, Action::DELETE);
	}
}
