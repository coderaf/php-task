<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Transaction;
use App\Request\Paginator\Pagination;
use App\Request\Paginator\PaginationDecorator;
use App\Request\Paginator\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TransactionRepository extends ServiceEntityRepository implements TransactionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    public function findWithPagination(Pagination $pagination): PaginationDecorator
    {
        $result = $this->createQueryBuilder('t')
            ->setFirstResult(Paginator::getOffsetForPagination($pagination))
            ->setMaxResults($pagination->getPageSize())
            ->getQuery()
            ->getResult();
        $fullCount = $this->count([]);

        return PaginationDecorator::of(
            $fullCount,
            $pagination,
            $result
        );
    }

    public function findOne(string $id): ?Transaction
    {
        return parent::find($id);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }

    public function save(Transaction $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
