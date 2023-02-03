<?php

declare(strict_types=1);

namespace App\Builder;

use App\Entity\Transaction;

interface TransactionBuilderInterface
{
    public function buildFromArray(array $data): Transaction;
}