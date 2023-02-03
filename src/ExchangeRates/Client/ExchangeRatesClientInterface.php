<?php

declare(strict_types=1);

namespace App\ExchangeRates\Client;

use App\ExchangeRates\Client\Exception\ExchangeRatesClientException;
use Psr\Http\Message\ResponseInterface;

interface ExchangeRatesClientInterface
{
    /** @throws ExchangeRatesClientException */
    public function get(string $action, array $queryParameters = []): ResponseInterface;
}