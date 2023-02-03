<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TransactionRepository;
use App\ValueObject\PaymentMethod;
use App\ValueObject\TransactionType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255, enumType: PaymentMethod::class)]
    private ?PaymentMethod $paymentMethod;

    #[ORM\Column(length: 255, enumType: TransactionType::class)]
    private ?TransactionType $transactionType;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $timestamp;

    #[ORM\Column]
    private ?int $baseAmount;

    #[ORM\Column(length: 255)]
    private ?string $baseCurrency;

    #[ORM\Column]
    private ?int $targetAmount;

    #[ORM\Column(length: 255)]
    private ?string $targetCurrency;

    #[ORM\Column]
    private ?float $exchangeRate;

    #[ORM\Column(length: 255)]
    private ?string $refererIp;

    public function __construct(
        ?Uuid $id,
        ?PaymentMethod $paymentMethod,
        ?TransactionType $transactionType,
        ?\DateTimeInterface $timestamp,
        ?int $baseAmount,
        ?string $baseCurrency,
        ?int $targetAmount,
        ?string $targetCurrency,
        ?float $exchangeRate,
        ?string $refererIp
    ) {
        $this->id = $id;
        $this->paymentMethod = $paymentMethod;
        $this->transactionType = $transactionType;
        $this->timestamp = $timestamp;
        $this->baseAmount = $baseAmount;
        $this->baseCurrency = $baseCurrency;
        $this->targetAmount = $targetAmount;
        $this->targetCurrency = $targetCurrency;
        $this->exchangeRate = $exchangeRate;
        $this->refererIp = $refererIp;
    }

    public function setExchangeRate(?float $exchangeRate): void
    {
        $this->exchangeRate = $exchangeRate;
    }

    public function setTargetAmount(?int $targetAmount): void
    {
        $this->targetAmount = $targetAmount;
    }

    public function setTargetCurrency(?string $targetCurrency): void
    {
        $this->targetCurrency = $targetCurrency;
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getPaymentMethod(): ?PaymentMethod
    {
        return $this->paymentMethod;
    }

    public function getTransactionType(): ?TransactionType
    {
        return $this->transactionType;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function getBaseAmount(): ?int
    {
        return $this->baseAmount;
    }

    public function getBaseCurrency(): ?string
    {
        return $this->baseCurrency;
    }

    public function getTargetAmount(): ?int
    {
        return $this->targetAmount;
    }

    public function getTargetCurrency(): ?string
    {
        return $this->targetCurrency;
    }

    public function getExchangeRate(): ?float
    {
        return $this->exchangeRate;
    }

    public function getRefererIp(): ?string
    {
        return $this->refererIp;
    }
}

