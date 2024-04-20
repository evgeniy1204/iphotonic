<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\Query\MainPageQueryParams;
use App\Repository\EventRepository;
use App\Repository\NewsRepository;
use App\Repository\ProductCategoryRepository;
use App\Repository\ProductRepository;
use App\Response\MainPageResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    public function __construct(
        private readonly ProductCategoryRepository $productCategoryRepository,
        private readonly ProductRepository $productRepository,
        private readonly EventRepository $eventRepository,
        private readonly NewsRepository $newsRepository,
    )
    {
    }

    #[Route('/main', name: 'app_main_page')]
    public function index(
        #[MapQueryString] MainPageQueryParams $queryParams
    ): Response
    {
        $productCategories = $this->productCategoryRepository->findParentCategories();
        $products = $this->productRepository->findByCategoryId(
            $queryParams->getChildCategoryId()
        );
        $events = $this->eventRepository->findUpcomingEvents();
        $news = $this->newsRepository->findLatestNews();

        $response = new MainPageResponse(
            $productCategories,
            $products,
            $events,
            $news
        );
        dd($response);

        return $this->json([]);
    }
}
