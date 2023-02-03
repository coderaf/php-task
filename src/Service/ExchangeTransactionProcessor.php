<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Transaction;
use App\ExchangeRates\Client\Exception\ExchangeRatesClientException;
use App\ExchangeRates\Provider\Exception\ExchangeRateProviderException;
use App\ExchangeRates\Provider\Exception\ExchangeRateProviderMissingRatesException;
use App\ExchangeRates\Provider\ExchangeRateProviderInterface;
use App\Repository\TransactionRepositoryInterface;

readonly class ExchangeTransactionProcessor implements ExchangeTransactionProcessorInterface
{
    public function __construct(
        private ExchangeRateProviderInterface $exchangeRateProvider,
        private TransactionRepositoryInterface $repository,
    ){}

    public function process(Transaction $transaction): bool
    {
        try {
            $rate = $this->exchangeRateProvider->provide(
                $transaction->getBaseCurrency(),
                $transaction->getTargetCurrency()
            );
        } catch (ExchangeRateProviderException|ExchangeRateProviderMissingRatesException|ExchangeRatesClientException $e) {
            return false;
        }
        $transaction->setExchangeRate($rate);
        $transaction->setTargetAmount(
            MoneyAmountConverter::convertFromUnitsToUnits($transaction->getBaseAmount(), $rate)
        );

        $this->repository->save($transaction, true);

        return true;
    }
}
