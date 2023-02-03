<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\TransactionRepositoryInterface;
use App\Request\Paginator\Pagination;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GetExchangeTransactionController extends AbstractController
{
    public function __construct(
        private readonly TransactionRepositoryInterface $repository,
        private readonly SerializerInterface $serializer,
    ){}

    #[Route('/api/transaction', methods: ['GET'])]
    public function action(Request $request): JsonResponse
    {
        $pagination = new Pagination(
            $request->query->getInt('page'),
            $request->query->getInt('pageSize')
        );
        $paginatedList = $this->repository->findWithPagination($pagination);

        return new JsonResponse(
            $this->serializer->serialize($paginatedList, 'json'),
            Response::HTTP_OK,
            [],
            true,
        );
    }
}
