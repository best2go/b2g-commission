<?php

declare(strict_types=1);

namespace Best2Go\Best2GoCommission\FxRateProvider;

use RuntimeException;
use Throwable;

class FxRateProvider implements FxRateProviderInterface
{
    /** @var FxRateProviderInterface[]|array */
    private array $providers;

    public function __construct(iterable $providers)
    {
        $this->providers = is_array($providers) ? $providers : iterator_to_array($providers);
    }

    public function getRate(string $currency): float
    {
        foreach ($this->providers as $resolver) {
            try {
                return $resolver->getRate($currency);
            } catch (Throwable $exception) {
                continue;
            }
        }

        throw new RuntimeException(self::EXCEPTION_RATE_NOT_FOUND);
    }
}