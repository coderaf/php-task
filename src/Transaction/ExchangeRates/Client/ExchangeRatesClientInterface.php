<?php

declare(strict_types=1);

namespace App\Transaction\ExchangeRates\Client;

use App\Transaction\ExchangeRates\Client\Exception\ExchangeRatesClientException;
use Psr\Http\Message\ResponseInterface;

interface ExchangeRatesClientInterface
{
    /** @throws ExchangeRatesClientException */
    public function get(string $action, array $queryParameters = []): ResponseInterface;
}