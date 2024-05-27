<?php

declare(strict_types=1);

namespace Tests\Best2Go\Best2GoCommission\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;

trait WithClientResponse
{
    private function mockClientHandler(Client $client, callable $callback): void
    {
        $client->getConfig('handler')->push($callback);
    }

    private function mockClientResponse(Client $client, Response $response): void
    {
        $this->mockClientHandler($client, function (/* callable $handler */) use ($response): callable {
            return function (/* RequestInterface $request, array $options */) use ($response): FulfilledPromise {
                return new FulfilledPromise($response);
            };
        });
    }

    private function createJsonResponse(array $data): Response
    {
        return new Response(
            200,
            ['Content-Type' => 'application/json; charset=utf-8'],
            Utils::streamFor(json_encode($data))
        );
    }

    private function createXmlResponse(string $data): Response
    {
        return new Response(200, ['Content-Type' => 'text/xml; charset=utf-8'], Utils::streamFor($data));
    }
}
