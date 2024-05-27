<?php

declare(strict_types=1);

namespace Best2Go\Best2GoCommission;

final class FxRate
{
    private Currency $currency;
    private float $rate;

    private function __construct(Currency $currency, float $rate)
    {
        $this->currency = $currency;
        $this->rate = $rate;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getRate(): float
    {
        return $this->rate;
    }
}
