<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Download;
use App\Repository\ApplicationRepository;
use App\Repository\DownloadRepository;
use App\Repository\PossibilitiesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PageController extends AbstractController
{
	#[Route('/downloads', methods: [Request::METHOD_GET])]
	public function downloads(DownloadRepository $downloadRepository): Response
	{
		$downloads = $downloadRepository->findAll();

		return $this->render('page/downloads.html.twig', ['downloads' => $downloads]);
	}

	#[Route('/applications', methods: [Request::METHOD_GET])]
	public function applications(ApplicationRepository $applicationRepository): Response
	{
		$applications = $applicationRepository->findAll();

		return $this->render('page/applications.html.twig', ['applications' => $applications]);
	}

	#[Route('/possibilities', methods: [Request::METHOD_GET])]
	public function possibilities(PossibilitiesRepository $possibilitiesRepository): Response
	{
		$possibilities = $possibilitiesRepository->findPossibilitiesPage();

		return $this->render('page/possibilities.html.twig', ['possibilities' => $possibilities]);
	}

	#[Route('/downloads/{id}', name: 'download_file', methods: [Request::METHOD_GET])]
	public function search(Download $download): Response
	{
		return new BinaryFileResponse($download->getFilePath());
	}
}