<?php

declare(strict_types=1);

namespace App\Tests\ExchangeRatesApiIOTest\Provider;

use App\Transaction\ExchangeRates\Client\Exception\ExchangeRatesClientException;
use App\Transaction\ExchangeRates\Client\ExchangeRatesClientInterface;
use App\Transaction\ExchangeRates\Provider\Exception\ExchangeRateProviderException;
use App\Transaction\ExchangeRates\Provider\Exception\ExchangeRateProviderMissingRatesException;
use App\Transaction\ExchangeRatesApiIO\Provider\ExchangeRateProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Symfony\Contracts\Cache\CacheInterface;

class ExchangeRateProviderTest extends TestCase
{
    private ExchangeRatesClientInterface|MockObject $client;
    private CacheInterface|MockObject $cache;
    private int $cacheExpiresInSeconds = 100;

    public function setUp(): void
    {
        $this->client = $this->createMock(ExchangeRatesClientInterface::class);
        $this->cache = $this->createMock(CacheInterface::class);
    }

    public function testProvideThrowsExchangeRateProviderMissingRatesExceptionThrownWhenRateForCurrencyMissing()
    {
        $this->expectException(ExchangeRateProviderMissingRatesException::class);

        $provider = new ExchangeRateProvider($this->client, $this->cache, $this->cacheExpiresInSeconds);
        $this->cache->method('get')->willReturn([]);

        $provider->provide('USD', 'EUR');
    }

    public function testProvideReturnRates()
    {
        $provider = new ExchangeRateProvider($this->client, $this->cache, $this->cacheExpiresInSeconds);
        $this->cache->method('get')->willReturn([
            "EUR"=> 0.813399,
            "GBP"=> 0.72007,
            "JPY"=> 107.346001,
        ]);

        $result = $provider->provide('USD', 'EUR');

        $this->assertEquals(0.813399, $result);
    }

    public function testFreshRatesThrowsExchangeRateProviderExceptionWhenClientThrowsException()
    {
        $this->expectException(ExchangeRateProviderException::class);
        $this->client->method('get')->willThrowException(new ExchangeRatesClientException());

        $provider = new ExchangeRateProvider($this->client, $this->cache, $this->cacheExpiresInSeconds);

        $provider->getFreshRates('USD');
    }
    public function testFreshRatesThrowsExchangeRateProviderExceptionOnMalformedResponse()
    {
        $this->expectException(ExchangeRateProviderException::class);
        $this->client->method('get')->willReturn($this->getClientResponse(''));

        $provider = new ExchangeRateProvider($this->client, $this->cache, $this->cacheExpiresInSeconds);

        $provider->getFreshRates('USD');
    }

    public function testFreshRatesThrowsExchangeRateProviderExceptionOnStatusFalse()
    {
        $this->expectException(ExchangeRateProviderException::class);
        $body = json_encode(['status' => false]);
        $this->client->method('get')->willReturn($this->getClientResponse($body));

        $provider = new ExchangeRateProvider($this->client, $this->cache, $this->cacheExpiresInSeconds);

        $provider->getFreshRates('USD');
    }

    /**
     * TODO: this should be in separate fixture class
     */
    private function getClientResponse(string $body): ResponseInterface|MockObject
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')
            ->willReturn($body);

        return $response;
    }
}