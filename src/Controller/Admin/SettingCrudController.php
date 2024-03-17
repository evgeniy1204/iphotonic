<?php

namespace App\Controller\Admin;

use App\Entity\Partner;
use App\Entity\Setting;
use App\Field\TinyMCEField;
use App\SeoFieldsTrait;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class SettingCrudController extends AbstractCrudController
{
	use SeoFieldsTrait;

    public static function getEntityFqcn(): string
    {
        return Setting::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
			FormField::addTab('Social networks'),
			UrlField::new('linkedIn'),
			UrlField::new('youtube'),
			UrlField::new('instagram'),
            ...$this->getSeoFields(),
        ];
    }
}
