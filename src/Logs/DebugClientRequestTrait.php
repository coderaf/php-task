<?php

declare(strict_types=1);

namespace App\Logs;

use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

/**
 * Trait for debugin some action during client requests, working with guzzle.
 */
trait DebugClientRequestTrait
{
    use LoggerAwareWithNullCheckTrait;

    public function debugResponse(string $uniqueId, ResponseInterface $response): void
    {
        $this->getLogger()->debug(
            sprintf('[%s]:%s response %s',static::class, $uniqueId, $response->getBody()),
        );
    }

    public function debugRequest(string $method, string $uniqueId, string $url, ?array $data = null): void
    {
        $this->getLogger()->debug(
            sprintf('[%s]:%s %s request %s',static::class, $uniqueId, $method, $url), ['data' => $data]
        );
    }

    public function debugErrorResponse(\Throwable $throwable, string $uniqueId, ?int $trimResponse = null): void
    {
        $response = $throwable instanceof RequestException && $throwable->hasResponse() ?
            $throwable->getResponse() : null;

        $response = $response && $trimResponse ? substr((string)$response->getBody(), $trimResponse) : null;

        $this->getLogger()->error(
            sprintf('[%s]:%s response exception %s',static::class, $uniqueId, $response),
            ['exception' => $throwable]
        );
    }
}