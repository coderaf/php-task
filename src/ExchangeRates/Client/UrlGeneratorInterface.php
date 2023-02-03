<?php

declare(strict_types=1);

namespace App\ExchangeRates\Client;

interface UrlGeneratorInterface
{
    public function getUrl(string $action): string;
}