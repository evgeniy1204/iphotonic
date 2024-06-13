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
			->addJsFiles('scripts/tiny_mce_app.js');
	}
}