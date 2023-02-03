<?php

declare(strict_types=1);

namespace App\Transaction\ExchangeRates\Client\Exception;

class ExchangeRatesClientException extends \Exception
{
    private const MESSAGE = 'Retrieving exchange rates failed.';
    private const GENERAL_ERROR = 100;

    public static function withPrevious(\Throwable $previous): self
    {
        return new self(self::MESSAGE, self::GENERAL_ERROR, $previous);
    }
}
