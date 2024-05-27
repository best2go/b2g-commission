<?php

declare(strict_types=1);

namespace Best2Go\Best2GoCommission;

final class Country
{
    private string $iso2;

    public function __construct(string $iso2)
    {
        $this->iso2 = $iso2;
    }

    public function __toString(): string
    {
        return $this->iso2;
    }
}
