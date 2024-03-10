<?php

namespace App\Controller\Admin;

use App\Entity\Application;
use App\Entity\ApplicationCategory;
use App\Entity\Event;
use App\Entity\News;
use App\Entity\Page;
use App\Entity\Membership;
use App\Entity\Partner;
use App\Entity\ProductCategory;
use App\Entity\Technology;
use App\Entity\TechnologyCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        /**
         * @var AdminUrlGenerator $adminUrlGenerator
         */
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(PartnerCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Iphotonic')
            ->disableDarkMode();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Partners', 'fa fa-users', Partner::class);
        yield MenuItem::linkToCrud('Pages', 'fa fa-file-text', Page::class);
        yield MenuItem::linkToCrud('Memberships', 'fa fa-ticket', Membership::class);
        yield MenuItem::linkToCrud('News', 'fa fa-newspaper-o', News::class);
        yield MenuItem::linkToCrud('Events', 'fa fa-calendar', Event::class);
        yield MenuItem::linkToCrud('Product categories', 'fa fa-bar-chart', ProductCategory::class);
        yield MenuItem::linkToCrud('Technology categories', 'fa fa-bar-chart', TechnologyCategory::class);
        yield MenuItem::linkToCrud('Technologies', 'fa fa-laptop', Technology::class);
        yield MenuItem::linkToCrud('Application categories', 'fa fa-bar-chart', ApplicationCategory::class);
        yield MenuItem::linkToCrud('Applications', 'fa fa-file', Application::class);

    }
}
