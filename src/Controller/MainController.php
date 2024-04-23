<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\NewsRepository;
use App\Repository\ProductCategoryRepository;
use App\Repository\SettingRepository;
use App\Response\MainPageResponse;
use App\Service\SettingsProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/main', name: 'app_main_page')]
    public function index(
		NewsRepository $newsRepository,
		EventRepository $eventRepository,
		ProductCategoryRepository $productCategoryRepository,
		SettingsProvider $settingsProvider
	): Response {
        $productCategories = $productCategoryRepository->findParentCategories();
        $events = $eventRepository->findUpcomingEvents();
        $news = $newsRepository->findLatestNews();
        $membershipLogos = $settingsProvider->getMemberships();


        $response = new MainPageResponse(
            $productCategories,
            $events,
            $news,
            $membershipLogos
        );

        return $this->render('main_page/index.html.twig', ['data' => $response]);
    }
}
