<?php

declare(strict_types=1);

namespace App\Transaction;

use App\Entity\Transaction;

interface ExchangeTransactionProcessorInterface
{
    public function process(Transaction $transaction): bool;
}