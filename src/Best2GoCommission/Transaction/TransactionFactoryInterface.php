<?php

declare(strict_types=1);

namespace Best2Go\Best2GoCommission\Transaction;

interface TransactionFactoryInterface
{
    public function create(array $data): Transaction;
}