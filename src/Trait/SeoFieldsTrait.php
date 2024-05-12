<?php

namespace App\Trait;

use App\Entity\SeoEmbed;
use Doctrine\ORM\Mapping as ORM;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

trait SeoFieldsTrait
{
	#[ORM\Embedded(class: SeoEmbed::class, columnPrefix: false),]
	private SeoEmbed $seo;

	public function getSeoFields(): array
	{
		return [
			FormField::addTab('Seo'),
			TextField::new('metaTitle')->hideOnIndex(),
			TextField::new('metaDescription')->hideOnIndex(),
			TextField::new('metaKeywords')->hideOnIndex(),
		];
	}

	public function getSeo(): ?SeoEmbed
	{
		if ($this->seo->getMetaKeywords() || $this->seo->getMetaDescription() || $this->seo->getMetaTitle()) {
			return $this->seo;
		}

		return null;
	}

	public function getMetaTitle(): ?string
	{
		return $this->seo->getMetaTitle();
	}

	public function setMetaTitle(string $metaTitle): static
	{
		$this->seo->setMetaTitle($metaTitle);

		return $this;
	}

	public function getMetaDescription(): ?string
	{
		return $this->seo->getMetaDescription();
	}

	public function setMetaDescription(string $metaDescription): static
	{
		$this->seo->setMetaDescription($metaDescription);

		return $this;
	}

	public function getMetaKeywords(): ?string
	{
		return $this->seo->getMetaKeywords();
	}

	public function setMetaKeywords(string $metaKeywords): static
	{
		$this->seo->setMetaKeywords($metaKeywords);

		return $this;
	}
}