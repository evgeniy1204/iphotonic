<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/news-and-events')]
class NewsLandingController extends AbstractController
{
	#[Route('/articles', name: 'app_article_index')]
	public function articleList()
	{

	}

	#[Route('/articles/{slug}', name: 'app_article_item')]
	public function article(string $slug, NewsRepository $newsRepository): Response
	{
		$news = $newsRepository->findOneBy(['slug' => $slug]);

		return $this->render('news_and_events/index_article.html.twig', [
			'news' => $news,
		]);
	}

	#[Route('/events/{slug}', name: 'app_event_item')]
	public function event(string $slug, EventRepository $eventRepository): Response
	{
		$event = $eventRepository->findOneBy(['slug' => $slug]);

		return $this->render('news_and_events/index_event.html.twig', [
			'event' => $event,
		]);
	}
}