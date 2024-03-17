<?php

declare(strict_types=1);

namespace App\Controller;

use App\Response\TinyResponse;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FileController extends AbstractController
{
	private const TINE_UPLOAD_FOLDER = 'tiny';

	#[Route('/upload-files', methods: ['POST'])]
	public function uploadProductTextFile(Request $request, FileUploader $fileUploader): Response
	{
		$filePath = $fileUploader->upload($request->files->get('file'), self::TINE_UPLOAD_FOLDER);
		$filePath = sprintf('%s/%s', $request->getBasePath(), $filePath);

		return new Response((new TinyResponse($filePath))->getLocation());
	}
}