<?php

declare(strict_types=1);

namespace Best2Go\Best2GoCommission;

final class Money
{
    private Currency $currency;
    private string $amount;

    public function __construct($amount, Currency $currency)
    {
        $this->amount = (string) $amount;
        $this->currency = $currency;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getAmountAsFloat(): float
    {
        return (float) $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }
}