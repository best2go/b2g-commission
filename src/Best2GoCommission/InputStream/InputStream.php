<?php

declare(strict_types=1);

namespace Best2Go\Best2GoCommission\InputStream;

use Traversable;

class InputStream implements InputStreamProvider
{
    private iterable $stream;

    public function __construct(InputStreamProvider $stream)
    {
        $this->stream = $stream;
    }

    public function getIterator(): Traversable
    {
        foreach ($this->stream as $row) {
            yield $row;
        }
    }
}
