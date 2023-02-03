<?php

declare(strict_types=1);

namespace App\ExchangeRates\Provider;

use App\ExchangeRates\Provider\Exception\ExchangeRateProviderException;
use App\ExchangeRates\Provider\Exception\ExchangeRateProviderMissingRatesException;

interface ExchangeRateProviderInterface
{
    /** @throws ExchangeRateProviderMissingRatesException|ExchangeRateProviderException */
    public function provide(string $base, string $target): float;

    /** @throws ExchangeRateProviderMissingRatesException|ExchangeRateProviderException */
    public function getFreshRates(string $base): array;
}
