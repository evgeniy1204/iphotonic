<?php

namespace App\Entity;

use App\Constants;
use App\Repository\ApplicationRepository;
use App\SeoFieldsTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[
    ORM\Entity(repositoryClass: ApplicationRepository::class),
    ORM\Table(name: 'applications')
]
class Application
{
	use SeoFieldsTrait;

	public const APPLICATION_IMAGE_FOLDER= 'application';

    #[
        ORM\Id,
        ORM\GeneratedValue,
        ORM\Column
    ]
    private ?int $id = null;

    #[ORM\Column(name: 'text', type: Types::TEXT, nullable: true)]
    private ?string $text = null;

    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'applications')]
    private Collection $products;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

	#[ORM\Column(name: 'preview', type: Types::STRING, nullable: true)]
	private ?string $preview = null;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): static
	{
		$this->text = $text;

		return $this;
	}

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->addApplication($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            $product->removeApplication($this);
        }

        return $this;
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

	public function getPreview(): ?string
	{
		return $this->preview;
	}

	public function setPreview(?string $preview): void
	{
		$this->preview = $preview;
	}

	public function getPreviewPath(): string
	{
		return sprintf('%s%s/%s', Constants::ADMIN_ROOT_READ_IMAGES_DIR, self::APPLICATION_IMAGE_FOLDER, $this->preview);
	}
}
