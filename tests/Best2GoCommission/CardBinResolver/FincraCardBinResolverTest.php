<?php

declare(strict_types=1);

namespace Tests\Best2Go\Best2GoCommission\CardBinResolver;

use Best2Go\Best2GoCommission\CardBinResolver\FincraCardBinResolver;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Tests\Best2Go\Best2GoCommission\Traits;

class FincraCardBinResolverTest extends TestCase
{
    use Traits\WithClientResponse;

    /** @dataProvider data() */
    public function testResolve(string $bin, string $expected, array $response): void
    {
        $client = new Client();
        $this->mockClientResponse($client, $this->createJsonResponse($response));
        $fincraCardBinResolver = new FincraCardBinResolver($client);
        $country = $fincraCardBinResolver->resolve($bin);

        $this->assertEquals($expected, $country);
    }

    public function data(): iterable
    {
        return [
            'DK' => ['522692', 'DK', [
                'status' => true,
                'message' => 'Bin resolved',
                'data' => [
                    'bin' => '522692',
                    'scheme' => 'mastercard',
                    'brand' => 'Mastercard World Business Debit',
                    'country' => [
                        'code' => 'DK',
                        'name' => 'Denmark',
                        'emoji' => '🇩🇰'
                    ],
                    'bank' => [
                        'name' => 'Payoneer Europe Limited'
                    ],
                    'type' => 'debit',
                    'lengths' => [
                        16
                    ]
                ]
            ]],
            'UA' => ['462705', 'UA', [
                'status' => true,
                'message' => 'Bin resolved',
                'data' => [
                    'bin' => '462705',
                    'scheme' => 'visa',
                    'brand' => 'Visa Platinum',
                    'country' => [
                        'code' => 'UA',
                        'name' => 'Ukraine',
                        'emoji' => '🇺🇦'
                    ],
                    'bank' => [
                        'name' => 'Jsc Cb Privatbank'
                    ],
                    'type' => 'credit',
                    'lengths' => [
                        16,
                        18,
                        19
                    ]
                ]
            ]],
        ];
    }
}
