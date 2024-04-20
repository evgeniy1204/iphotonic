<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\NewsRepository;
use App\Repository\ProductCategoryRepository;
use App\Repository\SettingRepository;
use App\Response\MainPageResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    public function __construct(
        private readonly ProductCategoryRepository $productCategoryRepository,
        private readonly EventRepository $eventRepository,
        private readonly NewsRepository $newsRepository,
        private readonly SettingRepository $settingRepository,
    )
    {
    }

    #[Route('/main', name: 'app_main_page')]
    public function index(): Response
    {
        $productCategories = $this->productCategoryRepository->findParentCategories();
        $events = $this->eventRepository->findUpcomingEvents();
        $news = $this->newsRepository->findLatestNews();
        $membershipLogos = $this->settingRepository->findMemberships();


        $response = new MainPageResponse(
            $productCategories,
            $events,
            $news,
            $membershipLogos
        );

        return $this->render('main_page/index.html.twig', ['data' => $response]);
    }
}
