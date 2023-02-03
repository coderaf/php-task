<?php

declare(strict_types=1);

namespace App\Transaction\Updater;

use App\Entity\Transaction;

class TransactionUpdater implements TransactionUpdaterInterface
{
    public function updateFromArray(Transaction $transaction, array $data): Transaction
    {
        $transaction->setTargetCurrency($data['targetCurrency'] ?? null);

        return $transaction;
    }
}