<?php

declare(strict_types=1);

namespace App\Transaction\ExchangeRatesApiIO\Client;

use App\Logs\DebugClientRequestTrait;
use App\Request\UuidUniqueIdProvider;
use App\Transaction\ExchangeRates\Client\Exception\ExchangeRatesClientException;
use App\Transaction\ExchangeRates\Client\ExchangeRatesClientInterface;
use App\Transaction\ExchangeRates\Client\UrlGeneratorInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

class ExchangeRatesApiIOClient implements ExchangeRatesClientInterface
{
    use DebugClientRequestTrait;

    public function __construct(
        readonly private ClientInterface $client,
        readonly private UrlGeneratorInterface $urlGenerator,
        readonly private UuidUniqueIdProvider $uniqueIdProvider,
        readonly private string $exchangeRatesApiAccessKey,
    ){}

    public function get(string $action, array $queryParameters = []): ResponseInterface
    {
        $url = $this->urlGenerator->getUrl($action);
        $uniqueId = $this->uniqueIdProvider->getUniqueId();

        try {
            $this->debugRequest('GET', $uniqueId, $url);

            $response = $this->client->request(
                'GET',
                $url,
                [
                    RequestOptions::HEADERS => [
                        'apikey' => $this->exchangeRatesApiAccessKey
                    ],
                    RequestOptions::QUERY => $queryParameters
                ]
            );
            $this->debugResponse($uniqueId, $response);

        } catch (GuzzleException $exception) {
            $this->debugErrorResponse($exception, $uniqueId);

            throw ExchangeRatesClientException::withPrevious($exception);
        }

        return $response;
    }
}
