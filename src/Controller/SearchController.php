<?php

declare(strict_types=1);

namespace App\Controller;

use App\Response\SearchResponseCollection;
use App\Service\Pagination;
use App\Service\Search\SearchManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SearchController extends AbstractController
{
	#[Route('/search', name: 'app_search_content', methods: [Request::METHOD_GET])]
	public function search(
		Request $request,
		SearchManager $searchManager
	): Response {
		$searchText = $request->get('q');
		$searchResponseCollection = new SearchResponseCollection($searchText);

		if ($searchText) {
			foreach ($searchManager->searchByText($searchText) as $searchedItem) {
				$searchResponseCollection->addSearchItem($searchedItem);
			}
		}

		return $this->render('search_result.html.twig', ['searchResponse' => $searchResponseCollection]);
	}
}