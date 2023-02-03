<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Transaction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GetExchangeTransactionOneController extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
    ){}

    #[Route('/api/transaction/{id}', methods: ['GET'])]
    public function action(Transaction $transaction): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize($transaction, 'json'),
            Response::HTTP_OK,
            [],
            true,
        );
    }
}
