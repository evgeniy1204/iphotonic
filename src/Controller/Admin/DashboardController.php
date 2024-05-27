<?php

namespace App\Controller\Admin;

use App\Entity\AboutUs;
use App\Entity\Application;
use App\Entity\Download;
use App\Entity\Event;
use App\Entity\File;
use App\Entity\Media;
use App\Entity\Membership;
use App\Entity\News;
use App\Entity\Partner;
use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Entity\Setting;
use App\Entity\Technology;
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

        return $this->redirect(
			$adminUrlGenerator
				->setController(ProductCrudController::class)
				->generateUrl()
		);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('I-Photonics')
            ->disableDarkMode();
    }

    public function configureMenuItems(): iterable
    {
		yield MenuItem::linkToCrud('Product categories', 'fa fa-bar-chart', ProductCategory::class);
		yield MenuItem::linkToCrud('Files', 'fa fa-file', File::class);
		yield MenuItem::section('Catalog', 'fa fa-list');
		yield MenuItem::linkToCrud('Product', 'fa fa-cube', Product::class);
		yield MenuItem::linkToCrud('Applications', 'fa fa-file', Application::class);
		yield MenuItem::linkToCrud('Technologies', 'fa fa-laptop', Technology::class);
		yield MenuItem::section('Media Center', 'fa fa-list-alt');
		yield MenuItem::linkToCrud('News', 'fa fa-newspaper-o', News::class);
		yield MenuItem::linkToCrud('Events', 'fa fa-calendar', Event::class);
		yield MenuItem::linkToCrud('Photo & Video', 'fa fa-photo', Media::class);
		yield MenuItem::section('Site', 'fa fa-cogs');
		yield MenuItem::linkToCrud('Settings', 'fa fa-cog', Setting::class);
		yield MenuItem::linkToCrud('Downloads', 'fa fa-download', Download::class);
		yield MenuItem::linkToCrud('About us', 'fa fa-address-card', AboutUs::class);
		yield MenuItem::linkToCrud('Partners', 'fa fa-users', Partner::class);
		yield MenuItem::linkToCrud('Memberships', 'fa fa-users-rectangle', Membership::class);
    }
}
