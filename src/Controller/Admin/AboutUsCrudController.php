<?php

namespace App\Controller\Admin;

use App\Entity\AboutUs;
use App\Field\TinyMCEField;
use App\Repository\AboutUsRepository;
use App\Trait\SeoFieldsTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class AboutUsCrudController extends AbstractCrudController
{
	use SeoFieldsTrait;

	public function __construct(
		private readonly AdminUrlGenerator $adminUrlGenerator,
		private readonly AboutUsRepository $aboutUsRepository,
		#[Autowire('%env(TINY_MCE_JS_URL)%')] private readonly string $tinyMceJsUrl
	) {
	}

	public static function getEntityFqcn(): string
    {
        return AboutUs::class;
    }

	public function index(AdminContext $context)
	{
		$aboutUsPage = $this->aboutUsRepository->findAboutUsPage();
		if ($aboutUsPage) {
			$targetUrl = $this->adminUrlGenerator
				->setController(self::class)
				->setAction(Crud::PAGE_EDIT)
				->setEntityId($aboutUsPage->getId())
				->generateUrl();

			return $this->redirect($targetUrl);
		}

		return parent::index($context);
	}

	public function configureFields(string $pageName): iterable
    {
		return [
			FormField::addTab('General fields'),
            TinyMCEField::new('content')->addJsFiles($this->tinyMceJsUrl),
			...$this->getSeoFields(),
		];
    }
}
