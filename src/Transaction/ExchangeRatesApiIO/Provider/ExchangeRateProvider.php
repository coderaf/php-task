<?php

declare(strict_types=1);

namespace App\Transaction\ExchangeRatesApiIO\Provider;

use App\Transaction\ExchangeRates\Client\Exception\ExchangeRatesClientException;
use App\Transaction\ExchangeRates\Client\ExchangeRatesClientInterface;
use App\Transaction\ExchangeRates\Provider\Exception\ExchangeRateProviderException;
use App\Transaction\ExchangeRates\Provider\Exception\ExchangeRateProviderMissingRatesException;
use App\Transaction\ExchangeRates\Provider\ExchangeRateProviderInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class ExchangeRateProvider implements ExchangeRateProviderInterface
{
    private const ACTION_LATEST_RATES = 'latest';
    private const RETRIEVING_RATES_RESPONSE_MALFORMED = '[%s] 3rd party response malformed.';
    private const RETRIEVING_RATES_FAILED_SOME_GOOD_REASON = '[%s] 3rd party response failed for some good reason.';
    private const CACHE_KEY = 'exchange_rates_api_io_rates';

    public function __construct(
        readonly private ExchangeRatesClientInterface $exchangeRatesClient,
        readonly private CacheInterface $cache,
        readonly private int $cacheExpiresInSeconds,
    ){}

    public function provide(string $base, string $target): float
    {
        $rates = $this->cache->get(self::CACHE_KEY, function (ItemInterface $item) use ($base) {
            $item->expiresAfter($this->cacheExpiresInSeconds);

            return $this->getFreshRates($base);
        });

        foreach ($rates as $targetCurrency => $rate) {
            if ($targetCurrency === $target) {
                return $rate;
            }
        }
        throw new ExchangeRateProviderMissingRatesException();
    }

    public function getFreshRates(string $base): array
    {
        try {
            $response = $this->exchangeRatesClient->get(
                self::ACTION_LATEST_RATES,
                [
                    'base' => $base,
                ],
            );
        } catch (ExchangeRatesClientException $exception) {
            throw new ExchangeRateProviderException(
                sprintf(self::RETRIEVING_RATES_FAILED_SOME_GOOD_REASON, static::class)
            );
        }

        return $this->getRatesFromResponse($response);
    }

    private function getRatesFromResponse(ResponseInterface $response): array
    {
        try {
            $body = json_decode((string)$response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $exception) {
            throw new ExchangeRateProviderException(
                sprintf(self::RETRIEVING_RATES_RESPONSE_MALFORMED, static::class)
            );
        }

        if (
            $body['success'] !== true
            || !isset($body['rates'])
        ) {
            throw new ExchangeRateProviderException(
                sprintf(self::RETRIEVING_RATES_RESPONSE_MALFORMED, static::class)
            );
        }

        return $body['rates'];
    }
}
