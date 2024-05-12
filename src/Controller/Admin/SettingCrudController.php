<?php

namespace App\Controller\Admin;

use App\Constants;
use App\Entity\Setting;
use App\Repository\SettingRepository;
use App\Trait\SeoFieldsTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
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
			FormField::addTab('Contacts'),
			TextareaField::new('contacts'),
			FormField::addTab('About us'),
			TextareaField::new('about_us'),
			FormField::addTab('Social networks'),
			UrlField::new('linkedIn'),
			UrlField::new('youtube'),
			UrlField::new('instagram'),
			...$this->getSeoFields(),
		];
	}
}
