<?php

namespace App\Enum;

enum SearchResultTypeEnum: string
{
	case TYPE_PRODUCT = 'Products';
	case TYPE_TECHNOLOGY = 'Technology';
	case TYPE_NEWS = 'News';
	case TYPE_EVENT = 'Events';
}
