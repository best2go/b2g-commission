<?php

declare(strict_types=1);

namespace Best2Go\Best2GoCommission\InputStream;

use Traversable;

class ArrayInputStream implements InputStreamProvider
{
    private array $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function getIterator(): Traversable
    {
        yield from $this->items;
    }
}
