<?php

declare(strict_types=1);

namespace App\Service;

class MoneyAmountFormatter
{
    public static function fromDecimalToUnit(string $amountInDecimal): ?int
    {
        return (int)(round($amountInDecimal * 100));
    }
}
