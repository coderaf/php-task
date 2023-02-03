<?php

declare(strict_types=1);

namespace App\Request\Paginator;

readonly class Pagination
{
    private const DEFAULT_PAGE = 1;
    private const DEFAULT_PAGE_SIZE = 10;

    private ?int $page;
    private ?int $pageSize;
    public function __construct(?int $page, ?int $pageSize)
    {
        $this->page = empty($page) ? self::DEFAULT_PAGE : $page;
        $this->pageSize = empty($pageSize) ? self::DEFAULT_PAGE_SIZE : $pageSize;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPageSize(): int
    {
        return $this->pageSize;
    }
}
