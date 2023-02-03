<?php

declare(strict_types=1);

namespace App\Transaction\Builder;

use App\Entity\Transaction;
use App\Request\RefererIpProviderInterface;
use App\Transaction\MoneyAmountFormatter;
use App\ValueObject\PaymentMethod;
use App\ValueObject\TransactionType;
use Symfony\Component\Uid\Uuid;

readonly class TransactionBuilder implements TransactionBuilderInterface
{
    public function __construct(private RefererIpProviderInterface $refererIpProvider){}

    public function buildFromArray(array $data): Transaction
    {
        return new Transaction(
            isset($data['id']) ? Uuid::fromString($data['id']) : null,
            PaymentMethod::tryFrom($data['paymentMethod'] ?? ''),
            TransactionType::tryFrom($data['transactionType'] ?? ''),
            new \DateTime(),
            isset($data['baseAmount']) ? MoneyAmountFormatter::fromDecimalToUnit($data['baseAmount']) : null,
            $data['baseCurrency'] ?? null,
            null,
            $data['targetCurrency'] ?? null,
            null,
            $this->refererIpProvider->provide(),
        );
    }
}
