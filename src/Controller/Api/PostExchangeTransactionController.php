<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Transaction;
use App\Service\ExchangeTransactionProcessorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PostExchangeTransactionController extends AbstractController
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly ExchangeTransactionProcessorInterface $exchangeTransactionProcessor,
        private readonly SerializerInterface $serializer,
    ){}

    #[Route('/api/transaction', methods: ['POST'])]
    public function action(Transaction $transaction): JsonResponse
    {
        $errors = $this->validator->validate($transaction);

        if (count($errors) > 0) {
            return new JsonResponse(null,Response::HTTP_BAD_REQUEST);
        }
        $this->exchangeTransactionProcessor->process($transaction);

        return new JsonResponse(
            $this->serializer->serialize($transaction, 'json'),
            Response::HTTP_CREATED,
            [],
            true,
        );
    }
}
