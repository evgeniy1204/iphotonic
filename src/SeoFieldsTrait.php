<?php

namespace App;

use App\Entity\SeoEmbed;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Doctrine\ORM\Mapping as ORM;

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