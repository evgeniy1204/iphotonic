<?php

namespace App\Entity;

use App\Constants;
use App\Repository\DownloadRepository;
use App\Trait\SeoFieldsTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DownloadRepository::class)]
class Download
{
	use SeoFieldsTrait;

	public const DOWNLOAD_PREVIEW_FILE_FOLDER_PATH = 'download_preview';
	public const DOWNLOAD_FILE_FOLDER_PATH = 'download';

    #[
		ORM\Id,
		ORM\GeneratedValue,
		ORM\Column(name: 'id')
	]
    private int $id;

    #[ORM\Column(name: 'preview', type: Types::STRING, length: 255)]
    private ?string $preview;

    #[ORM\Column(name: 'file_name', type: Types::STRING, length: 255)]
    private ?string $fileName;

    #[ORM\Column(name:'file', type: Types::STRING, length: 255)]
    private ?string $file;

	public function __construct()
	{
		$this->id = 0;
		$this->preview = null;
		$this->fileName = null;
		$this->file = null;
		$this->seo = new SeoEmbed();
	}

	public function getId(): int
    {
        return $this->id;
    }

    public function getPreview(): ?string
    {
        return $this->preview;
    }

    public function setPreview(string $preview): static
    {
        $this->preview = $preview;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): static
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

	public function getFilePath(): string
	{
		return sprintf('%s%s/%s', Constants::ADMIN_ROOT_READ_IMAGES_DIR, self::DOWNLOAD_FILE_FOLDER_PATH, $this->file);
	}

    public function setFile(string $file): static
    {
        $this->file = $file;

        return $this;
    }
}
