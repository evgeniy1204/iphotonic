<?php

namespace App\Controller\Admin;

use App\Entity\Application;
use App\Repository\ApplicationCategoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ApplicationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Application::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
			ImageField::new('images')
				->setBasePath(Application::APPLICATION_IMAGES_BASE_PATH)
				->setUploadDir('public/' . Application::APPLICATION_IMAGES_BASE_PATH)
				->setFormTypeOption('multiple', true),
            TextEditorField::new('text'),
            AssociationField::new('category')->setFormTypeOptions(
                [
                    'query_builder' => function (ApplicationCategoryRepository $applicationCategoryRepository) {
                        return $applicationCategoryRepository->createQueryBuilder('ac')
                            ->andWhere('ac.children IS EMPTY');
                    }
                ]
            )->setRequired(true)
        ];
    }
}
