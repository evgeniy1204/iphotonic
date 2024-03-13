<?php

namespace App\Controller\Admin;

use App\Entity\Technology;
use App\Repository\TechnologyCategoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TechnologyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Technology::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
			ImageField::new('images')
				->setBasePath(Technology::TECHNOLOGY_IMAGES_BASE_PATH)
				->setUploadDir('public/' . Technology::TECHNOLOGY_IMAGES_BASE_PATH)
				->setFormTypeOption('multiple', true),
            TextEditorField::new('text'),
            AssociationField::new('category')->setFormTypeOptions(
                [
                    'query_builder' => function (TechnologyCategoryRepository $technologyCategoryRepository) {
                        return $technologyCategoryRepository->createQueryBuilder('tc')
                            ->andWhere('tc.children IS EMPTY');
                    }
                ]
            )->setRequired(true)
        ];
    }
}
