<?php

declare(strict_types=1);

namespace Best2Go\Best2GoCommission\CommissionProvider;

interface CommissionProviderInterface
{
    public const EXCEPTION_UNKNOWN_COUNTRY = 'unknown country';

    /** @throws */
    public function getCommissionByCountry(string $iso2): float;
}
