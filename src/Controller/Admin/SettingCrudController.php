<?php

namespace App\Controller\Admin;

use App\Constants;
use App\Entity\Setting;
use App\Field\TinyMCEField;
use App\Repository\SettingRepository;
use App\Trait\SeoFieldsTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class SettingCrudController extends AbstractCrudController
{
	use SeoFieldsTrait;

	public function __construct(
		private readonly AdminUrlGenerator $adminUrlGenerator,
		private readonly SettingRepository $settingRepository
	) {
	}

	public static function getEntityFqcn(): string
	{
		return Setting::class;
	}

	public function index(AdminContext $context)
	{
		$settingPage = $this->settingRepository->findSettingPage();
		if ($settingPage) {
			$targetUrl = $this->adminUrlGenerator
				->setController(self::class)
				->setAction(Crud::PAGE_EDIT)
				->setEntityId($settingPage->getId())
				->generateUrl();

			return $this->redirect($targetUrl);
		}

		return parent::index($context);
	}

	public function configureFields(string $pageName): iterable
	{
		return [
			FormField::addTab('Main page'),
			TextField::new('mainLeftBlockTitle'),
			UrlField::new('mainLeftBlockTitleUrl'),
			TextareaField::new('mainLeftBlockSummary'),
			ImageField::new('mainLeftBlockImage')
				->hideOnIndex()
				->setBasePath(Constants::ADMIN_ROOT_READ_IMAGES_DIR . Setting::MAIN_BLOCK_IMAGES_FOLDER)
				->setUploadDir(Constants::ADMIN_ROOT_UPLOADS_DIR . Setting::MAIN_BLOCK_IMAGES_FOLDER)
				->setRequired(false),
			TextField::new('mainRightBlockTitle'),
			UrlField::new('mainRightBlockTitleUrl'),
			TextareaField::new('mainRightBlockSummary'),
			ImageField::new('mainRightBlockImages')
				->hideOnIndex()
				->setBasePath(Constants::ADMIN_ROOT_READ_IMAGES_DIR . Setting::MAIN_BLOCK_IMAGES_FOLDER)
				->setUploadDir(Constants::ADMIN_ROOT_UPLOADS_DIR . Setting::MAIN_BLOCK_IMAGES_FOLDER)
				->setFormTypeOption('multiple', true)
				->setRequired(false),
			FormField::addTab('Contacts'),
			TextareaField::new('contacts'),
			FormField::addTab('About us'),
			TextareaField::new('aboutUs'),
			FormField::addTab('Social networks'),
			UrlField::new('linkedIn'),
			UrlField::new('youtube'),
			UrlField::new('instagram'),
			FormField::addTab('Technology'),
			TinyMCEField::new('technologyContent')->hideOnIndex(),
			...$this->getSeoFields(),
		];
	}
}
