<?php

declare(strict_types=1);

namespace Best2Go\Best2GoCommission;

final class Currency
{
    private string $iso3;

    public function __construct(string $iso3)
    {
        $this->iso3 = $iso3;
    }

    public function __toString(): string
    {
        return $this->iso3;
    }
}
