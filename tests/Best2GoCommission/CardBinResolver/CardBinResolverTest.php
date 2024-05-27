<?php

declare(strict_types=1);

namespace Tests\Best2Go\Best2GoCommission\CardBinResolver;

use Best2Go\Best2GoCommission\CardBinResolver\CardBinResolver;
use Best2Go\Best2GoCommission\CardBinResolver\CardBinResolverInterface;
use Exception;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class CardBinResolverTest extends TestCase
{
    public function testResolveException()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(CardBinResolverInterface::EXCEPTION_BIN_NOT_RESOLVED);

        $mock = $this->getMockBuilder(CardBinResolverInterface::class)
            ->onlyMethods(['resolve'])
            ->getMock();

        $mock->expects($this->exactly(3))
            ->method('resolve')
            ->willThrowException(new Exception('***'));

        $resolvers = [$mock, $mock, $mock];

        $cardBinResolver = new CardBinResolver($resolvers);
        $cardBinResolver->resolve('424242');
    }

    public function testResolveSuccess()
    {
        $mock = $this->getMockBuilder(CardBinResolverInterface::class)
            ->onlyMethods(['resolve'])
            ->getMock();

        $mock->expects($this->exactly(2))
            ->method('resolve')
            ->willReturnCallback(function (string $bin): string {
                static $throwException = true;

                if ($throwException) {
                    $throwException = false;
                    throw new RuntimeException('***');
                }

                return $bin === '424242' ? 'XX' : 'ZZ';
            });

        $resolvers = [$mock, $mock, $mock];

        $cardBinResolver = new CardBinResolver($resolvers);
        $this->assertSame('XX', $cardBinResolver->resolve('424242'));
    }
}