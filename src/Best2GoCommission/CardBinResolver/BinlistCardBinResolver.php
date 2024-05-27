<?php

declare(strict_types=1);

namespace Best2Go\Best2GoCommission\CardBinResolver;

use GuzzleHttp\Client;
use RuntimeException;

class BinlistCardBinResolver implements CardBinResolverInterface
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /** @throws */
    public function resolve(string $bin): string
    {
        $response = $this->client->get($bin);
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);

        if (!isset($data['country']['alpha2'])) {
            throw new RuntimeException(self::EXCEPTION_BIN_NOT_RESOLVED);
        }

        return $data['country']['alpha2'];
    }
}
