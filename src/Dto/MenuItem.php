<?php

declare(strict_types=1);

namespace App\Dto;

class MenuItem
{
	public function __construct(private string $name, private string $url, private array $children = [])
	{
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getUrl(): string
	{
		return $this->url;
	}

	public function addChild(MenuItem $item)
	{
		$this->children[] = $item;
	}

	/**
	 * @return MenuItem[]
	 */
	public function getChildren(): array
	{
		return $this->children;
	}
}