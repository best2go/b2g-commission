<?php

declare(strict_types=1);

namespace Best2Go\Best2GoCommission\CommissionProvider;

class CommissionProvider implements CommissionProviderInterface
{
    private const EU = [
        'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI',
        'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT',
        'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK',
    ];

    public function getCommissionByCountry(string $iso2): float
    {
        return $this->isEuropeanUnion($iso2) ? 0.01 : 0.02;
    }

    private function isEuropeanUnion(string $iso2): bool
    {
        return in_array($iso2, self::EU, true);
    }
}
