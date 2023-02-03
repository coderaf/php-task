<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Transaction;

interface ExchangeTransactionProcessorInterface
{
    public function process(Transaction $transaction): bool;
}