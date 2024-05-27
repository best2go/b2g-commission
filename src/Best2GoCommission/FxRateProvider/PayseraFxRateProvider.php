<?php

declare(strict_types=1);

namespace Best2Go\Best2GoCommission\FxRateProvider;

use GuzzleHttp\Client;
use RuntimeException;

class PayseraFxRateProvider implements FxRateProviderInterface
{
    private Client $client;
    private string $base;
    private array $cache;

    public function __construct(Client $client, string $base = 'EUR')
    {
        $this->client = $client;
        $this->base = $base;
    }

    /** @throws */
    public function getRate(string $currency): float
    {
        $this->init();

        return $this->cache[$currency];
    }

    /** @throws */
    private function init(): void
    {
        if (isset($this->cache)) {
            return;
        }

        $response = $this->client->get('')->getBody()->getContents();
        $data = json_decode($response, true);
        if ($data['base'] !== $this->base) {
            throw new RuntimeException('Invalid base currency!');
        }

        $this->cache = $data['rates'];
    }
}
