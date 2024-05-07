<?php

declare(strict_types=1);

namespace App\Field;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

final class TinyMCEField implements FieldInterface
{
	use FieldTrait;

	public static function new(string $propertyName, ?string $label = null): self
	{
		return (new self())
			->setProperty($propertyName)
			->setLabel($label)
			->setFormType(TextareaType::class)
			->addCssClass('field-tiny-editor')
			->addJsFiles('https://cdn.tiny.cloud/1/ixvc0l7tbwt2huihvu5t0n5w6u6v6ow9uebmu27mwguaaylr/tinymce/6/tinymce.min.js')
			->addJsFiles('app/scripts/tiny_mce_app.js');
	}
}