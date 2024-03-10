<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            DateTimeField::new('createdEventStartAt')
                ->setTimezone($this->getParameter('app.timezone_id')),
            DateTimeField::new('createdEventEndAt')
                ->setTimezone($this->getParameter('app.timezone_id')),
            DateTimeField::new('createdAt')
                ->setTimezone($this->getParameter('app.timezone_id')),
            TextEditorField::new('text'),
        ];
    }
}
