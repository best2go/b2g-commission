<?php

declare(strict_types=1);

namespace Best2Go\Best2GoCommission\Transaction;

interface TransactionProcessorInterface
{
    public function process(Transaction $transaction): void;
}