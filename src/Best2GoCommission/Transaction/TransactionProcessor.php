<?php

declare(strict_types=1);

namespace Best2Go\Best2GoCommission\Transaction;

use Best2Go\Best2GoCommission\CardBinResolver\CardBinResolverInterface;
use Best2Go\Best2GoCommission\CommissionProvider\CommissionProviderInterface;
use Best2Go\Best2GoCommission\FeeCalculator\FeeCalculatorInterface;
use Best2Go\Best2GoCommission\FxRateProvider\FxRateProviderInterface;
use RuntimeException;
use Throwable;

class TransactionProcessor implements TransactionProcessorInterface
{
    private CardBinResolverInterface $cardBinResolver;
    private FxRateProviderInterface $fxRateProvider;
    private CommissionProviderInterface $commissionProvider;
    private FeeCalculatorInterface $feeCalculator;

    public function __construct(
        CardBinResolverInterface $cardBinResolver,
        FxRateProviderInterface $fxRateProvider,
        CommissionProviderInterface $commissionProvider,
        FeeCalculatorInterface $feeCalculator
    ) {
        $this->cardBinResolver = $cardBinResolver;
        $this->fxRateProvider = $fxRateProvider;
        $this->commissionProvider = $commissionProvider;
        $this->feeCalculator = $feeCalculator;
    }

    public function process(Transaction $transaction): void
    {
        try {
            $this->resolveCountry($transaction);
            $this->applyFxRate($transaction);
            $this->applyCommission($transaction);
            $this->applyFee($transaction);
            $transaction->setMessage('OK');
        } catch (Throwable $exception) {
            $transaction->setMessage($exception->getMessage());
        }
    }

    private function resolveCountry(Transaction $transaction): void
    {
        $transaction->setCountry($this->cardBinResolver->resolve($transaction->getBin()));
    }

    private function applyFxRate(Transaction $transaction): void
    {
        $transaction->setRate($this->fxRateProvider->getRate($transaction->getCurrency()));
    }

    private function applyCommission(Transaction $transaction): void
    {
        if (!$transaction->hasCountry()) {
            throw new RuntimeException('Transaction country required');
        }

        $transaction->setCommission($this->commissionProvider->getCommissionByCountry($transaction->getCountry()));
    }

    private function applyFee(Transaction $transaction): void
    {
        $transaction->setFee($this->feeCalculator->calc($transaction));
    }
}