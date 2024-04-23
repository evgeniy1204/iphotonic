<?php

namespace App\Controller;

use App\Repository\TechnologyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/technology')]
class TechnologyLandingController extends AbstractController
{
	#[Route('/', name: 'app_technology_index')]
	public function index(): Response
    {
		return new Response();
	}

    #[Route('/{technologyCategorySlug}/{technologySubCategorySlug?}', name: 'app_technology_item')]
    public function technologyCategory(
		string $technologyCategorySlug,
		?string $technologySubCategorySlug,
		TechnologyRepository $technologyRepository
	): Response {
        $technology = $technologyRepository->findOneBy(['slug' => $technologySubCategorySlug ?? $technologyCategorySlug]);

        return $this->render('technology_category/index.html.twig', [
            'technologyCategory' => $technology,
        ]);
    }
}
