<?php

declare(strict_types=1);

namespace App\Enum;

enum MenuType: string
{
	case PRODUCT_CATEGORY_MENU = 'product_category_menu';
	case TECHNOLOGY_CATEGORY_MENU = 'technology_category_menu';
}