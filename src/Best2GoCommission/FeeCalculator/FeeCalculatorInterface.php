<?php

declare(strict_types=1);

namespace Best2Go\Best2GoCommission\FeeCalculator;

use Best2Go\Best2GoCommission\Transaction\Transaction;

interface FeeCalculatorInterface
{
    public function calc(Transaction $transaction): float;
}
