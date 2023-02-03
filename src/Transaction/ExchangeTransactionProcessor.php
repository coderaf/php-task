<?php

declare(strict_types=1);

namespace App\Transaction;

use App\Entity\Transaction;
use App\Repository\TransactionRepositoryInterface;
use App\Transaction\ExchangeRates\Client\Exception\ExchangeRatesClientException;
use App\Transaction\ExchangeRates\Provider\Exception\ExchangeRateProviderException;
use App\Transaction\ExchangeRates\Provider\Exception\ExchangeRateProviderMissingRatesException;
use App\Transaction\ExchangeRates\Provider\ExchangeRateProviderInterface;

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
