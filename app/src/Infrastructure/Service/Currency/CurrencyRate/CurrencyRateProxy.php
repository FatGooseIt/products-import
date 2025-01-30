<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Currency\CurrencyRate;

/**
 * Proxy implementation of CurrencyRateInterface with caching.
 *
 * This class acts as a proxy to another implementation of CurrencyRateInterface, adding caching
 * functionality to improve performance by avoiding redundant calls to the underlying service.
 */
final class CurrencyRateProxy implements CurrencyRateInterface
{
    /**
     * @var array<string, float> A cache of exchange rates, keyed by currency code.
     */
    private array $cache = [];

    /**
     * @param CurrencyRateInterface $currencyRate - The underlying currency rate service
     *                                              to which this proxy delegates calls.
     */
    public function __construct(
        private readonly CurrencyRateInterface $currencyRate,
    ) {
    }

    /**
     * Get the daily exchange rate for the given currency with caching.
     *
     * @param string $currency - The three-letter ISO 4217 currency code (e.g., 'EUR', 'GBP', 'JPY').
     *
     * @return float - The exchange rate for the specified currency relative to the base currency (e.g., USD).
     */
    public function getDailyRate(string $currency): float
    {
        if (isset($this->cache[$currency])) {
            return $this->cache[$currency];
        }

        $result = $this->currencyRate->getDailyRate($currency);
        $this->cache[$currency] = $result;

        return $result;
    }
}
