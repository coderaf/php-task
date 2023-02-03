<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Transaction;
use App\Request\Paginator\Pagination;
use App\Request\Paginator\PaginationDecorator;

interface TransactionRepositoryInterface
{
    public function save(Transaction $entity, bool $flush = false): void;
    public function findAll(): array;
    public function findWithPagination(Pagination $pagination): PaginationDecorator;
    public function findOne(string $id): ?Transaction;
}
