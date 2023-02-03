<?php

declare(strict_types=1);

namespace App\Transaction\ExchangeRates\Provider;

use App\Transaction\ExchangeRates\Provider\Exception\ExchangeRateProviderException;
use App\Transaction\ExchangeRates\Provider\Exception\ExchangeRateProviderMissingRatesException;

interface ExchangeRateProviderInterface
{
    /** @throws ExchangeRateProviderMissingRatesException|ExchangeRateProviderException */
    public function provide(string $base, string $target): float;

    /** @throws ExchangeRateProviderMissingRatesException|ExchangeRateProviderException */
    public function getFreshRates(string $base): array;
}
