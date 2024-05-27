<?php

declare(strict_types=1);

namespace Best2Go\Best2GoCommission\CardBinResolver;

use RuntimeException;
use Throwable;

class CardBinResolver implements CardBinResolverInterface
{
    /** @var CardBinResolverInterface[]|array */
    private array $resolvers;

    public function __construct(iterable $resolvers)
    {
        $this->resolvers = is_array($resolvers) ? $resolvers : iterator_to_array($resolvers);
    }

    public function resolve(string $bin): string
    {
        foreach ($this->resolvers as $resolver) {
            try {
                return $resolver->resolve($bin);
            } catch (Throwable $exception) {
                continue;
            }
        }

        throw new RuntimeException(self::EXCEPTION_BIN_NOT_RESOLVED);
    }
}
