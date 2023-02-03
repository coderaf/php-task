<?php

declare(strict_types=1);

namespace App\Updater;

use App\Entity\Transaction;

interface TransactionUpdaterInterface
{
    public function updateFromArray(Transaction $transaction, array $data): Transaction;
}