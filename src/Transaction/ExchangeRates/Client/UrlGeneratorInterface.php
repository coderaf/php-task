<?php

declare(strict_types=1);

namespace App\Transaction\ExchangeRates\Client;

interface UrlGeneratorInterface
{
    public function getUrl(string $action): string;
}