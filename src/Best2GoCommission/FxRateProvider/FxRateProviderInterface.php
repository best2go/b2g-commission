<?php

declare(strict_types=1);

namespace Best2Go\Best2GoCommission\FxRateProvider;

use Best2Go\Best2GoCommission\FxRate;

interface FxRateProviderInterface
{
    public const EXCEPTION_RATE_NOT_FOUND = 'rate not found';

    /** @return float|FxRate */
    public function getRate(string $currency): float;
}
