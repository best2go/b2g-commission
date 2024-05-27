<?php

declare(strict_types=1);

namespace Tests\Best2Go\Best2GoCommission\CardBinResolver;

use Best2Go\Best2GoCommission\CardBinResolver\BinlistCardBinResolver;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Tests\Best2Go\Best2GoCommission\Traits;

class BinlistCardBinResolverTest extends TestCase
{
    use Traits\WithClientResponse;

    /** @dataProvider data() */
    public function testResolve(string $bin, string $expected, array $response): void
    {
        $client = new Client();
        $this->mockClientResponse($client, $this->createJsonResponse($response));
        $bi = new BinlistCardBinResolver($client);
        $country = $bi->resolve($bin);

        $this->assertEquals($expected, $country);
    }

    public function data(): iterable
    {
        return [
            'DK' => ['522692', 'DK', [
                'number' => [],
                'scheme' => 'mastercard',
                'type' => 'debit',
                'brand' => 'Mastercard World Business Debit',
                'country' => [
                    'numeric' => '208',
                    'alpha2' => 'DK',
                    'name' => 'Denmark',
                    'emoji' => '🇩🇰',
                    'currency' => 'DKK',
                    'latitude' => 56,
                    'longitude' => 10
                ],
                'bank' => [
                    'name' => 'Payoneer Europe Limited'
                ],
            ]],
            'UA' => ['462705', 'UA', [
                'number' => [],
                'scheme' => 'visa',
                'type' => 'credit',
                'brand' => 'Visa Platinum',
                'country' => [
                    'numeric' => '804',
                    'alpha2' => 'UA',
                    'name' => 'Ukraine',
                    'emoji' => '🇺🇦',
                    'currency' => 'UAH',
                    'latitude' => 49,
                    'longitude' => 32
                ],
                'bank' => [
                    'name' => 'Jsc Cb Privatbank'
                ],
            ]],
        ];
    }
}