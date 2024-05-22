<?php

namespace App\Entity;

use App\Constants;
use App\Repository\FileRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[ORM\Entity(repositoryClass: FileRepository::class)]
class File
{
	public const FILES_FOLDER_PATH = 'files';

	#[
		ORM\Id,
		ORM\GeneratedValue,
		ORM\Column(name: 'id')
	]
	private int $id;

    #[ORM\Column(name: 'name', type: Types::STRING, length: 255, nullable: true)]
    private ?string $name;

    #[ORM\Column(name: 'file', type: Types::STRING, length: 255, nullable: true)]
    private ?string $file;

    #[ORM\Column(name: 'full_path', type: Types::STRING, length: 255, nullable: true)]
    private ?string $fullPath;

	public function __construct()
	{
		$this->id = 0;
		$this->file = null;
		$this->name = null;
		$this->fullPath = null;
	}

	public function getId(): int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): static
    {
        $this->file = $file;
		$this->fullPath = sprintf('%s%s/%s',Constants::ADMIN_ROOT_READ_IMAGES_DIR, self::FILES_FOLDER_PATH, $file);

        return $this;
    }

    public function getFullPath(): ?string
    {
        return $this->fullPath;
    }

	public function getOriginalFullPath(): ?string
	{
		return $this->fullPath;
	}

    public function setFullPath(string $fullPath): static
    {
        $this->fullPath = $fullPath;

        return $this;
    }
}
