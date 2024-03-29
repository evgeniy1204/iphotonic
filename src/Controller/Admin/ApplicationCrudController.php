<?php

namespace App\Controller\Admin;

use App\Constants;
use App\Entity\Application;
use App\Field\TinyMCEField;
use App\Repository\ApplicationCategoryRepository;
use App\SeoFieldsTrait;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ApplicationCrudController extends AbstractCrudController
{
	use SeoFieldsTrait;

    public static function getEntityFqcn(): string
    {
        return Application::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
			FormField::addTab('General fields'),
            TextField::new('name'),
			ImageField::new('images')
				->setBasePath(Application::APPLICATION_IMAGE_FOLDER)
				->setUploadDir(Constants::ADMIN_ROOT_UPLOADS_DIR . Application::APPLICATION_IMAGE_FOLDER)
				->setFormTypeOption('multiple', true)
				->hideOnIndex(),
            TinyMCEField::new('text')->hideOnIndex(),
            AssociationField::new('category')->setFormTypeOptions(
                [
                    'query_builder' => function (ApplicationCategoryRepository $applicationCategoryRepository) {
                        return $applicationCategoryRepository->createQueryBuilder('ac')
                            ->andWhere('ac.children IS EMPTY');
                    }
                ]
            )->setRequired(true),
			...$this->getSeoFields(),
        ];
    }
}
