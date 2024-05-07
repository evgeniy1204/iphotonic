<?php

namespace App\Entity;

use App\Repository\PageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class SeoEmbed
{
    #[ORM\Column(name: 'metaTitle', length: 255, nullable: true)]
    private ?string $metaTitle = null;

    #[ORM\Column(name: 'metaDescription', length: 255, nullable: true)]
    private ?string $metaDescription = null;

    #[ORM\Column(name: 'metaKeywords', length: 255, nullable: true)]
    private ?string $metaKeywords = null;

    public function getMetaTitle(): ?string
    {
        return $this->metaTitle;
    }

    public function setMetaTitle(string $metaTitle): static
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(string $metaDescription): static
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    public function getMetaKeywords(): ?string
    {
        return $this->metaKeywords;
    }

    public function setMetaKeywords(string $metaKeywords): static
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }
}
