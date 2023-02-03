<?php

declare(strict_types=1);

namespace App\Request\Paginator;

readonly class PaginationDecorator
{
    public function __construct(
        private int $fullCount,
        private int $page,
        private int $pageSize,
        private array $items,
    ){}

    public static function of(int $fullCount, Pagination $pagination, array $result): self
    {
        return new self(
            $fullCount,
            $pagination->getPage(),
            $pagination->getPageSize(),
            $result
        );
    }

    public function getFullCount(): int
    {
        return $this->fullCount;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
