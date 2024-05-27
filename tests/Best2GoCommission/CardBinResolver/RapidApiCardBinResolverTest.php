<?php

declare(strict_types=1);

namespace Tests\Best2Go\Best2GoCommission\CardBinResolver;

use Best2Go\Best2GoCommission\CardBinResolver\RapidapiCardBinResolver;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Tests\Best2Go\Best2GoCommission\Traits;

class RapidApiCardBinResolverTest extends TestCase
{
    use Traits\WithClientResponse;

    /** @dataProvider data() */
    public function testResolve(string $bin, string $expected, array $response): void
    {
        $client = new Client();
        $this->mockClientResponse($client, $this->createJsonResponse($response));
        $rapidApiCardBinResolver = new RapidapiCardBinResolver($client);
        $country = $rapidApiCardBinResolver->resolve($bin);

        $this->assertEquals($expected, $country);
    }

    public function data(): iterable
    {
        return [
            'FR' => ['522692', 'FR', [
                'bin' => '522692',
                'brand' => 'MASTERCARD',
                'card_type' => 'DEBIT',
                'issuer' => 'PAYONEER EUROPE LIMITED',
                'country' => 'FR',
                'level' => 'Business Premium Debit',
            ]],
            'UA' => ['462705', 'UA', [
                'bin' => '462705',
                'brand' => 'VISA',
                'card_type' => 'CREDIT',
                'issuer' => 'JSC CB PRIVATBANK',
                'country' => 'UA',
                'level' => 'Visa Platinum'
            ]],
        ];
    }
}