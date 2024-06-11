<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Download;
use App\Repository\AboutUsRepository;
use App\Repository\ApplicationRepository;
use App\Repository\DownloadRepository;
use App\Repository\PartnerRepository;
use App\Service\Search\SettingsProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PageController extends AbstractController
{
	#[Route('/about', name: 'app_about_index', methods: [Request::METHOD_GET])]
	public function aboutUs(AboutUsRepository $aboutUsRepository): Response
	{
		$about = $aboutUsRepository->findAboutUsPage();

		return $this->render('page/about.html.twig', ['about' => $about]);
	}

	#[Route('/contacts', name: 'app_contacts_index', methods: [Request::METHOD_GET])]
	public function contacts(
		SettingsProvider $settingsProvider,
		PartnerRepository $partnerRepository
	): Response {

		return $this->render('page/contacts.html.twig', [
			'about' => $settingsProvider->getAboutUsContent(),
			'contacts' => $settingsProvider->getContacts(),
			'socialLinks' => $settingsProvider->getSocialLinks(),
			'partnerPoints' => $partnerRepository->findAll(),
			'partners' => $partnerRepository->findBy(['showPartnerCard' => true]),
		]);
	}

	#[Route('/downloads', name: 'app_downloads_index', methods: [Request::METHOD_GET])]
	public function downloads(DownloadRepository $downloadRepository): Response
	{
		$downloads = $downloadRepository->findAll();

		return $this->render('page/downloads.html.twig', ['downloads' => $downloads]);
	}

	#[Route('/applications', name: 'app_application_index', methods: [Request::METHOD_GET])]
	public function applications(ApplicationRepository $applicationRepository): Response
	{
		$applications = $applicationRepository->findAll();

		return $this->render('page/applications.html.twig', ['applications' => $applications]);
	}

	#[Route('/downloads/{id}', name: 'app_download_file', methods: [Request::METHOD_GET])]
	public function search(Download $download): Response
	{
		return new BinaryFileResponse($download->getFilePath());
	}
}