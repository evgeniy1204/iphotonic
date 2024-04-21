<?php

declare(strict_types=1);

namespace App\Controller;

use App\Response\SearchResponseCollection;
use App\Response\SearchResponseItem;
use App\Service\SearchManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SearchController extends AbstractController
{
	#[Route('/search', methods: ['GET'])]
	public function search(
		Request $request,
		SearchManager $searchManager
	): Response {
		$searchText = $request->get('q');
		$searchResponseCollection = new SearchResponseCollection($searchText);

		if ($searchText) {
			foreach ($searchManager->searchByText($searchText) as $searchedItem) {
				$searchResponseCollection->addSearchItem(new SearchResponseItem(
					$searchedItem->getSearchResultType(),
					$searchedItem->getSearchResultTitle(),
					$searchedItem->getSearchedResultShortText(),
					$searchManager->generateResultUrl($searchedItem->getSearchResultType(), $searchedItem->getSearchResultSlug()),
				));
			}
		}

		return $this->render('base.html.twig', ['searchResponse' => $searchResponseCollection]);
	}
}