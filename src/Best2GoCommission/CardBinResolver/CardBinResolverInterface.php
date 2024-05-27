<?php

declare(strict_types=1);

namespace Best2Go\Best2GoCommission\CardBinResolver;

use Best2Go\Best2GoCommission\Country;

interface CardBinResolverInterface
{
    public const EXCEPTION_BIN_NOT_RESOLVED = 'BIN not resolved';

    /** @return Country|string Country ISO2 code */
    public function resolve(string $bin): string;
}
