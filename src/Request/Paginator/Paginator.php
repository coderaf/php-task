<?php

declare(strict_types=1);

namespace App\Request\Paginator;

readonly class Paginator
{
    public static function getOffsetForPagination(Pagination $pagination): int
    {
        return $pagination->getPage() == 1 ? 0 :
            ($pagination->getPage() -1 ) * $pagination->getPageSize();
    }
}
