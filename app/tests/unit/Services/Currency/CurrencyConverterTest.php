<?php

declare(strict_types=1);

namespace App\Tests\unit\Services\Currency;

use App\Infrastructure\Service\Currency\CurrencyConverter\CurrencyConverter;
use App\Infrastructure\Service\Currency\CurrencyRate\CurrencyRateInterface;
use PHPUnit\Framework\TestCase;

class CurrencyConverterTest extends TestCase
{
    private const string CURRENCY = 'GBP';

    private const string INVALID_CURRENCY = 'INVALID';

    private const float DAILY_RATE = 1.22;

    private CurrencyRateInterface $currencyRateMock;
    private CurrencyConverter $currencyConverter;

    protected function setUp(): void
    {
        $this->currencyRateMock = $this->createMock(CurrencyRateInterface::class);
        $this->currencyConverter = new CurrencyConverter($this->currencyRateMock);
    }

    public static function amountDataProvider(): array
    {
        return [
            [0.0],
            [10.0],
            [5.6],
            [5],
        ];
    }

    /**
     * @dataProvider amountDataProvider
     */
    public function testConvertToUSD(float $amount): void
    {
        $this->currencyRateMock
            ->expects($this->once())
            ->method('getDailyRate')
            ->with(self::CURRENCY)
            ->willReturn(self::DAILY_RATE);
        $convertedAmount = $this->currencyConverter->convertToUSD($amount, self::CURRENCY);

        $expectedAmount = $amount * self::DAILY_RATE;

        $this->assertSame($expectedAmount, $convertedAmount);
    }

    /**
     * @dataProvider amountDataProvider
     */
    public function testConvertToUSDWithInvalidCurrency(float $amount): void
    {
        $this->currencyRateMock
            ->expects($this->once())
            ->method('getDailyRate')
            ->with(self::INVALID_CURRENCY)
            ->willThrowException(new \RuntimeException('Invalid currency'));

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Invalid currency');

        $this->currencyConverter->convertToUSD($amount, self::INVALID_CURRENCY);
    }
}
