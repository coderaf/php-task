<?php

declare(strict_types=1);

namespace App\Tests\functional\Api;

use App\Factory\TransactionFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetExchangeTransactionControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    public function tearDown(): void
    {
        TransactionFactory::truncate();
        parent::tearDown();
    }

    public function testSuccessEmptyResponse()
    {
        $this->client->request('GET', '/api/transaction');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
        $responseBody = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(
            [
                'fullCount' => 0,
                'page' => 1,
                'pageSize' => 10,
                'items' => []
            ],
            $responseBody
        );
    }

    public function testSuccessWithDefaultPagination()
    {
        TransactionFactory::createOne();
        TransactionFactory::createOne();

        $this->client->request('GET', '/api/transaction');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
        $responseBody = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(1, $responseBody['page'] );
        $this->assertEquals(10, $responseBody['pageSize'] );
        $this->assertEquals(2, $responseBody['fullCount'] );
        $this->assertCount(2, $responseBody['items'] );
        $this->assertArrayHasKey('id', $responseBody['items'][0]);
        $this->assertArrayHasKey('baseAmount',$responseBody['items'][0]);
        $this->assertArrayHasKey('baseCurrency',$responseBody['items'][0]);
    }

    public function testSuccessWithSetPagination()
    {
        TransactionFactory::createOne();
        TransactionFactory::createOne();
        TransactionFactory::createOne();

        $this->client->request('GET', '/api/transaction?page=2&pageSize=2');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
        $responseBody = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(2, $responseBody['page'] );
        $this->assertEquals(2, $responseBody['pageSize'] );
        $this->assertCount(1, $responseBody['items'] );
        $this->assertEquals(3, $responseBody['fullCount'] );
        $this->assertArrayHasKey('id', $responseBody['items'][0]);
        $this->assertArrayHasKey('baseAmount',$responseBody['items'][0]);
        $this->assertArrayHasKey('baseCurrency',$responseBody['items'][0]);
    }
}
