<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\MainProductsCollectionResponse;
use App\Repository\EventRepository;
use App\Repository\NewsRepository;
use App\Repository\ProductCategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\SettingRepository;
use App\Response\MainPageResponse;
use App\Service\SettingsProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main_page')]
    public function index(
		NewsRepository $newsRepository,
		EventRepository $eventRepository,
		ProductCategoryRepository $productCategoryRepository,
		ProductRepository $productRepository,
		SettingsProvider $settingsProvider
	): Response {
        $events = $eventRepository->findUpcomingEvents();
        $news = $newsRepository->findLatestNews();
        $membershipLogos = $settingsProvider->getMemberships();
		$productsResult = [];
		foreach ($productCategoryRepository->findParentCategories() as $productCategory) {
			$finalCategories = $productCategory->getFinalCategories();
			$productsResult[$productCategory->getName()] = [];
			foreach ($finalCategories as $finalCategory) {
				$products = $productRepository->findProductsForMainPageWithCategory($finalCategory);
				$productsResult[$productCategory->getName()][] = new MainProductsCollectionResponse($finalCategory, $products);
			}
		}

        $response = new MainPageResponse(
			$productsResult,
            $events,
            $news,
            $membershipLogos
        );

        return $this->render('main_page/index.html.twig', ['data' => $response]);
    }
}
