<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Transaction;
use App\Service\ExchangeTransactionProcessorInterface;
use App\Updater\TransactionUpdaterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PatchExchangeTransactionController extends AbstractController
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly ExchangeTransactionProcessorInterface $exchangeTransactionProcessor,
        private readonly SerializerInterface $serializer,
        private readonly TransactionUpdaterInterface $updater,
    ){}

    #[Route('/api/transaction', methods: ['PATCH'])]
    public function action(Request $request, Transaction $transaction): JsonResponse
    {
        $transaction = $this->updater->updateFromArray($transaction, $request->toArray());
        $errors = $this->validator->validate($transaction);

        if (count($errors) > 0) {
            return new JsonResponse(null,Response::HTTP_BAD_REQUEST);
        }
        $this->exchangeTransactionProcessor->process($transaction);

        return new JsonResponse(
            $this->serializer->serialize($transaction, 'json'),
            Response::HTTP_OK,
            [],
            true,
        );
    }
}
