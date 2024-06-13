<?php

namespace App\Controller\Admin;

use App\Constants;
use App\Entity\Application;
use App\Field\TinyMCEField;
use App\Trait\SeoFieldsTrait;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class ApplicationCrudController extends AbstractCrudController
{
	use SeoFieldsTrait;

	public function __construct(#[Autowire('%env(TINY_MCE_JS_URL)%')] private readonly string $tinyMceJsUrl)
	{
	}

	public static function getEntityFqcn(): string
    {
        return Application::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
			FormField::addTab('General fields'),
            TextField::new('name')->setRequired(true),
			ImageField::new('preview')
				->setBasePath(Constants::ADMIN_ROOT_READ_IMAGES_DIR . Application::APPLICATION_IMAGE_FOLDER)
				->setUploadDir(Constants::ADMIN_ROOT_UPLOADS_DIR . Application::APPLICATION_IMAGE_FOLDER)
				->hideOnIndex(),
            TinyMCEField::new('text')->hideOnIndex()->addJsFiles($this->tinyMceJsUrl),
			...$this->getSeoFields(),
        ];
    }
}
