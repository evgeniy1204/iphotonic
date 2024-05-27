<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\MediaRepository;
use App\Repository\NewsRepository;
use App\Service\Pagination;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/news-and-events')]
class MediaCenterLandingController extends AbstractController
{
	private const PAGINATE_DEFAULT_PER_PAGE = 13;

	#[Route('/', name: 'app_media_center_index')]
	public function mediaCenterList(
		EventRepository $eventRepository,
		NewsRepository $newsRepository,
		MediaRepository $mediaRepository
	): Response
	{
		$events = $eventRepository->findUpcomingEvents(4);
		$news = $newsRepository->findLatestNews(4);
		$media = $mediaRepository->findOneLastMedia();

		return $this->render('media_center/media_center_index.html.twig', [
			'events' => $events,
			'news' => $news,
			'media' => $media,
		]);
	}

	#[Route('/articles', name: 'app_article_index', methods: [Request::METHOD_GET])]
	public function articleList(Request $request, NewsRepository $newsRepository): Response {
		$pagination = new Pagination(self::PAGINATE_DEFAULT_PER_PAGE, (int) $request->get('page', 1));
		$pagination->setTotalItems($newsRepository->findAllActiveCount());
		$articles = $newsRepository->buildPaginationArticles($pagination);

		return $this->render('media_center/article_index.html.twig', [
			'pagination' => $pagination->buildPaginationResponse($articles),
		]);
	}

	#[Route('/events', name: 'app_event_index', methods: [Request::METHOD_GET])]
	public function eventsList(Request $request, EventRepository $eventRepository): Response
	{
		$pagination = new Pagination(self::PAGINATE_DEFAULT_PER_PAGE, $request->get('page', 1));
		$pagination->setTotalItems($eventRepository->findAllActiveCount());
		$events = $eventRepository->buildPaginationArticles($pagination);

		return $this->render('media_center/event_index.html.twig', [
			'pagination' => $pagination->buildPaginationResponse($events),
		]);
	}

	#[Route('/photos', name: 'app_photo_and_video_index', methods: [Request::METHOD_GET])]
	public function photoAndVideoList(Request $request,MediaRepository $mediaRepository): Response
	{
		$pagination = new Pagination(self::PAGINATE_DEFAULT_PER_PAGE, (int) $request->get('page', 1));
		$pagination->setTotalItems($mediaRepository->findAllActiveCount());
		$media = $mediaRepository->buildPaginationArticles($pagination);

		return $this->render('media_center/photo_index.html.twig', [
			'pagination' => $pagination->buildPaginationResponse($media),
		]);
	}

	#[Route('/articles/{slug}', name: 'app_article_item', methods: [Request::METHOD_GET])]
	public function article(string $slug, NewsRepository $newsRepository): Response
	{
		$news = $newsRepository->findOneBy(['slug' => $slug]);
		$otherNews = $newsRepository->findLatestNews();

		return $this->render('media_center/article_item.html.twig', [
			'news' => $news,
			'otherNews' => $otherNews,
		]);
	}

	#[Route('/events/{slug}', name: 'app_event_item', methods: [Request::METHOD_GET])]
	public function event(string $slug, EventRepository $eventRepository): Response
	{
		$event = $eventRepository->findOneBy(['slug' => $slug]);
		$otherEvents = $eventRepository->findUpcomingEvents(3);

		return $this->render('media_center/event_item.html.twig', [
			'event' => $event,
			'otherEvents' => $otherEvents,
		]);
	}

	#[Route('/media/{slug}', name: 'app_media_item', methods: [Request::METHOD_GET])]
	public function media(string $slug, MediaRepository $mediaRepository): Response
	{
		$media = $mediaRepository->findOneBy(['slug' => $slug]);
		if (!$media) {
			throw new NotFoundHttpException();
		}
		$nextMedia = $mediaRepository->findNextMediaAfter($media);

		return $this->render('media_center/photo_item.html.twig', [
			'media' => $media,
			'nextMedia' => $nextMedia,
		]);
	}
}