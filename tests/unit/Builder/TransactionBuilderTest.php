<?php

declare(strict_types=1);

namespace App\Tests\Builder;

use App\Builder\TransactionBuilder;
use App\Entity\Transaction;
use App\Request\RefererIpProviderInterface;
use App\ValueObject\PaymentMethod;
use App\ValueObject\TransactionType;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class TransactionBuilderTest extends TestCase
{
    private RefererIpProviderInterface|MockObject $refererIpProvider;

    protected function setUp(): void
    {
        $this->refererIpProvider = $this->createMock(RefererIpProviderInterface::class);
        $this->refererIpProvider->method('provide')->willReturn('localhost');
    }

    public function testBuildEmptyTransactionForEmptyArray()
    {
        $builder = new TransactionBuilder($this->refererIpProvider);
        $data = [];
        $result = $builder->buildFromArray($data);

        $this->assertInstanceOf(Transaction::class, $result);
    }

    public function testBuildProperObject()
    {
        $builder = new TransactionBuilder($this->refererIpProvider);
        $data = [
            'baseAmount' => '10.00',
            'baseCurrency' => 'USD',
            'targetCurrency' => 'EUR',
            'paymentMethod' => 'card',
            'transactionType' => 'deposit',
        ];
        $result = $builder->buildFromArray($data);

        $this->assertEquals(PaymentMethod::CARD, $result->getPaymentMethod());
        $this->assertEquals(TransactionType::Deposit, $result->getTransactionType());
        $this->assertEquals(1000, $result->getBaseAmount());
        $this->assertEquals('USD', $result->getBaseCurrency());
        $this->assertEquals('EUR', $result->getTargetCurrency());
        $this->assertEquals('localhost', $result->getRefererIp());
    }
}