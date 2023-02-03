<?php

declare(strict_types=1);

namespace App\Service;

class MoneyAmountConverter
{
    public static function convertFromUnitsToUnits(int $amountInUnits, float $rate): int
    {
        return (int)floor($amountInUnits * $rate);
    }
}