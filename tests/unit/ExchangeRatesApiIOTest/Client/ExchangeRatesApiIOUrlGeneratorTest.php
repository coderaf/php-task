<?php

declare(strict_types=1);

namespace App\Tests\ExchangeRatesApiIOTest\Client;

use App\ExchangeRatesApiIO\Client\ExchangeRatesApiIOUrlGenerator;
use PHPUnit\Framework\TestCase;

class ExchangeRatesApiIOUrlGeneratorTest extends TestCase
{
    public function testGetUrlGenerateProperUrl()
    {
        $urlGenerator = new ExchangeRatesApiIOUrlGenerator(
            'localhost',
            'v1',
        );
        $result = $urlGenerator->getUrl('latest');

        $this->assertEquals('localhost/v1/latest', $result);

    }
}
