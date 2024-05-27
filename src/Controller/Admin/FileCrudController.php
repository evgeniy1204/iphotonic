<?php

namespace App\Controller\Admin;

use App\Constants;
use App\Entity\File;
use App\Trait\SeoFieldsTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class FileCrudController extends AbstractCrudController
{
	use SeoFieldsTrait;

	public function __construct(#[Autowire('%env(BASE_DOMAIN)%')] private string $baseDomain)
	{
	}

	public static function getEntityFqcn(): string
    {
        return File::class;
    }

	public function configureCrud(Crud $crud): Crud
	{
		$crud->overrideTemplates([
			'crud/field/text' => 'admin/fields/file_text.html.twig',
		]);

		return parent::configureCrud($crud);
	}

	public function configureFields(string $pageName): iterable
    {
		return [
            TextField::new('name')->setRequired(true),
			ImageField::new('file')
				->setRequired(false)
				->hideOnIndex()
				->setBasePath(Constants::ADMIN_ROOT_READ_IMAGES_DIR . File::FILES_FOLDER_PATH)
				->setUploadDir(Constants::ADMIN_ROOT_UPLOADS_DIR . File::FILES_FOLDER_PATH),
			TextField::new('fullPath')
				->setLabel('Path')
				->hideOnForm()
		];
    }
}
