<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\MembershipRepository;
use App\Repository\NewsRepository;
use App\Repository\ProductCategoryRepository;
use App\Repository\ProductRepository;
use App\Response\MainPageResponse;
use App\Response\MainProductsCollectionResponse;
use App\Service\Search\SettingsProvider;
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
		MembershipRepository $membershipRepository,
		SettingsProvider $settingsProvider
	): Response {
        $events = $eventRepository->findUpcomingEvents();
        $news = $newsRepository->findLatestNews();
        $membershipLogos = $membershipRepository->findAll();
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
			$settingsProvider->getSettings(),
			$productsResult,
            $events,
            $news,
            $membershipLogos
        );

        return $this->render('main_page/index.html.twig', ['data' => $response]);
    }
}
