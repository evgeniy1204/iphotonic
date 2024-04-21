<?php

namespace App\Controller\Admin;

use App\Constants;
use App\Entity\AboutUs;
use App\Entity\Download;
use App\Field\TinyMCEField;
use App\Repository\AboutUsRepository;
use App\SeoFieldsTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AboutUsCrudController extends AbstractCrudController
{
	use SeoFieldsTrait;

	public function __construct(
		private readonly AdminUrlGenerator $adminUrlGenerator,
		private readonly AboutUsRepository $aboutUsRepository,
	){
	}

	public static function getEntityFqcn(): string
    {
        return AboutUs::class;
    }

	public function index(AdminContext $context): RedirectResponse
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
            TinyMCEField::new('description'),
			...$this->getSeoFields(),
		];
    }
}
