<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Currency\CurrencyRate;

/**
 * Mock implementation of CurrencyRateInterface for testing purposes.
 */
final class CurrencyRateMock implements CurrencyRateInterface
{
    private const array CURRENCY_CODES = ['GBP'];

    /**
     * Get a mock daily exchange rate for the given currency.
     *
     * @param string $currency - The three-letter ISO 4217 currency code (e.g., 'EUR', 'GBP', 'JPY').
     *                           This parameter is accepted but not used in this mock implementation.
     *
     * @return float - A fixed exchange rate of 1.22.
     * @throws \Exception
     */
    public function getDailyRate(string $currency): float
    {
        if (!in_array($currency, self::CURRENCY_CODES)) {
            throw new \Exception('Not find currency code');
        }

        return 1.22;
    }
}
