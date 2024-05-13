<?php

namespace App\Controller;

use App\Repository\TechnologyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/technology')]
class TechnologyLandingController extends AbstractController
{
	#[Route('', name: 'app_technology_index', methods: [Request::METHOD_GET])]
	public function index(TechnologyRepository $technologyRepository): Response
    {
		return $this->render('technology/index.html.twig', [
			'technologies' => $technologyRepository->findAll(),
		]);
	}

    #[Route('/{technologyCategorySlug}/{technologySubCategorySlug?}', name: 'app_technology_item', methods: [Request::METHOD_GET])]
    public function technologyCategory(
		string $technologyCategorySlug,
		?string $technologySubCategorySlug,
		TechnologyRepository $technologyRepository
	): Response {
        $technology = $technologyRepository->findOneBy(['slug' => $technologySubCategorySlug ?? $technologyCategorySlug]);

        return $this->render('technology/item.html.twig', [
            'technology' => $technology,
        ]);
    }
}
