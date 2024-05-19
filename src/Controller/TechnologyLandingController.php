<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\TechnologyRepository;
use App\Service\Search\SettingsProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/technology')]
class TechnologyLandingController extends AbstractController
{
	#[Route('', name: 'app_technology_index', methods: [Request::METHOD_GET])]
	public function index(
		TechnologyRepository $technologyRepository,
		SettingsProvider $settingsProvider
	): Response {

		return $this->render('technology/index.html.twig', [
			'technologies' => $technologyRepository->findBy(['active' => true]),
			'content' => $settingsProvider->getTechnologyContent(),
		]);
	}

    #[Route('/{technologyCategorySlug}/{technologySubCategorySlug?}', name: 'app_technology_item', methods: [Request::METHOD_GET])]
    public function technologyCategory(
		string $technologyCategorySlug,
		?string $technologySubCategorySlug,
		TechnologyRepository $technologyRepository,
		ProductRepository $productRepository,
	): Response {
        $technology = $technologyRepository->findOneBy(['slug' => $technologySubCategorySlug ?? $technologyCategorySlug]);
		$products = $productRepository->findByTechnology($technology);

        return $this->render('technology/item.html.twig', [
            'technology' => $technology,
			'products' => $products,
        ]);
    }
}
