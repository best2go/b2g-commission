<?php

declare(strict_types=1);

namespace Best2Go\Best2GoCommission\InputStream;

use Best2Go\Best2GoCommission\Transaction\Transaction;
use IteratorAggregate;
use Traversable;

interface InputStreamProvider extends IteratorAggregate
{
    /** @return Transaction[]|Traversable */
    public function getIterator(): Traversable;
}
