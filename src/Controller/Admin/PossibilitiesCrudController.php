<?php

namespace App\Controller\Admin;

use App\Entity\Possibilities;
use App\Field\TinyMCEField;
use App\Repository\PossibilitiesRepository;
use App\Trait\SeoFieldsTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class PossibilitiesCrudController extends AbstractCrudController
{
	use SeoFieldsTrait;

	public function __construct(
		private readonly AdminUrlGenerator $adminUrlGenerator,
		private readonly PossibilitiesRepository $possibilitiesRepository,
	){
	}

	public static function getEntityFqcn(): string
    {
        return Possibilities::class;
    }

	public function index(AdminContext $context)
	{
		$possibilities = $this->possibilitiesRepository->findPossibilitiesPage();
		if ($possibilities) {
			$targetUrl = $this->adminUrlGenerator
				->setController(self::class)
				->setAction(Crud::PAGE_EDIT)
				->setEntityId($possibilities->getId())
				->generateUrl();

			return $this->redirect($targetUrl);
		}

		return parent::index($context);
	}

	public function configureFields(string $pageName): iterable
    {
		return [
			FormField::addTab('General fields'),
            TinyMCEField::new('content')
				->setRequired(false),
			...$this->getSeoFields(),
		];
    }
}
