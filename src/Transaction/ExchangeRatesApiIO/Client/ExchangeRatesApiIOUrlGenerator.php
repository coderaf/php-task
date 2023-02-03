<?php

declare(strict_types=1);

namespace App\Transaction\ExchangeRatesApiIO\Client;

use App\Transaction\ExchangeRates\Client\UrlGeneratorInterface;

readonly class ExchangeRatesApiIOUrlGenerator implements UrlGeneratorInterface
{
    private const URL_PATTERN = '%s/%s/%s';

    public function __construct(
        private string $exchangeRatesApiBaseUrl,
        private string $exchangeRatesApiVersion,
    ){}

    public function getUrl(string $action): string
    {
        return sprintf(
            self::URL_PATTERN,
            $this->exchangeRatesApiBaseUrl,
            $this->exchangeRatesApiVersion,
            $action,
        );
    }
}
