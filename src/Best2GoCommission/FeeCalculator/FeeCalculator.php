<?php

declare(strict_types=1);

namespace Best2Go\Best2GoCommission\FeeCalculator;

use Best2Go\Best2GoCommission\Transaction\Transaction;
use RuntimeException;

class FeeCalculator implements FeeCalculatorInterface
{
    public function calc(Transaction $transaction): float
    {
        if (!$transaction->hasRate()) {
            throw new RuntimeException('Transaction rate required');
        }

        if (!$transaction->hasCommission()) {
            throw new RuntimeException('Transaction commission required');
        }

        return $transaction->getAmount() / $transaction->getRate() * $transaction->getCommission();
    }
}
