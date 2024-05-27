<?php

declare(strict_types=1);

namespace Best2Go\Best2GoCommission\Transaction;

class TransactionFactory implements TransactionFactoryInterface
{
    public function create(array $data): Transaction
    {
        $transaction = new Transaction();
        $transaction->setBin($data['bin']);
        $transaction->setCurrency($data['currency']);
        $transaction->setAmount((float) $data['amount']);

        return $transaction;
    }
}
