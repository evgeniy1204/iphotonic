<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\CardInfoDto;
use App\Dto\ProductCategoryDto;
use App\Repository\EventRepository;
use App\Repository\MembershipRepository;
use App\Repository\NewsRepository;
use App\Repository\ProductCategoryRepository;
use App\Repository\ProductRepository;
use App\Response\MainPageResponse;
use App\Response\MainProductsCollectionResponse;
use App\Service\Search\SettingsProvider;
use App\Service\UrlGenerator;
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
		SettingsProvider $settingsProvider,
		UrlGenerator $urlGenerator,
	): Response {
        $events = $eventRepository->findUpcomingEvents();
        $news = $newsRepository->findLatestNews();
        $membershipLogos = $membershipRepository->findAll();
		$productsResult = [];
		foreach ($productCategoryRepository->findParentCategories() as $productCategory) {
			$products = $productRepository->findProductsForMainPageWithCategoryIds([$productCategory->getId()]);
			if ($products) {
				foreach ($products as $product) {
					$productCards = [];
					$productCards[] = new CardInfoDto(
						$product->getPreviewImagePath(),
						$urlGenerator->generateProductUrl($product),
						$product->getName(),
						$product->getSummary(),
						$product->getMenuOrder(),
					);
					$productsResult[$productCategory->getName()][] = new MainProductsCollectionResponse(new ProductCategoryDto(
						$product->getId(),
						$product->getName(),
					), $productCards, $product->getMenuOrder());
				}
			}
			foreach ($productCategory->getChildren() as $childCategory) {
				$finalCategories = $childCategory->getFinalCategories();
				$categoriesIds = [];
				$categoriesIds[] = $childCategory->getId();
				foreach ($finalCategories as $finalCategory) {
					$categoriesIds[] = $finalCategory->getId();
				}
				$productCards = [];
				$products = $productRepository->findProductsForMainPageWithCategoryIds($categoriesIds);
				if ($products) {
					foreach ($products as $product) {
						$productCards[] = new CardInfoDto(
							$product->getPreviewImagePath(),
							$urlGenerator->generateProductUrl($product),
							$product->getName(),
							$product->getSummary(),
							$product->getMenuOrder(),
						);
					}
				} else {
					foreach ($childCategory->getChildren() as $child) {
						$productCards[] = new CardInfoDto(
							$child->getPreviewImagePath(),
							$urlGenerator->generateProductCategoryUrl($child),
							$child->getName(),
							$child->getSummary(),
							$child->getMenuOrder(),
						);
					}
				}
				if ($productCards) {
					$productsResult[$productCategory->getName()][] = new MainProductsCollectionResponse(new ProductCategoryDto($childCategory->getId(), $childCategory->getName()), $productCards, $childCategory->getMenuOrder());
				}
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
