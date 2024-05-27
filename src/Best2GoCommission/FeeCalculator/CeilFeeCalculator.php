<?php

declare(strict_types=1);

namespace Best2Go\Best2GoCommission\FeeCalculator;

use Best2Go\Best2GoCommission\Transaction\Transaction;

class CeilFeeCalculator implements FeeCalculatorInterface
{
    private FeeCalculatorInterface $base;

    public function __construct(FeeCalculatorInterface $base)
    {
        $this->base = $base;
    }

    public function calc(Transaction $transaction): float
    {
        return ceil($this->base->calc($transaction) * 100) / 100;
    }
}
