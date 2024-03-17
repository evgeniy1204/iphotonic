<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

readonly class FileUploader
{
	public function __construct(
		private SluggerInterface $slugger,
		#[Autowire('%env(TARGET_UPLOAD_DIRECTORY)%')]
		private string $rootUploadDirectory,
	) {
	}

	public function upload(UploadedFile $file, $targetDirectory): string
	{
		$originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
		$safeFilename = $this->slugger->slug($originalFilename);
		$fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
		$filePath = sprintf('%s/%s/%s', $this->rootUploadDirectory, $targetDirectory, $fileName);

		try {
			$file->move(sprintf('%s/%s', $this->rootUploadDirectory, $targetDirectory), $fileName);
		} catch (FileException $e) {
		}

		return $filePath;
	}
}