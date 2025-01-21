<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Currency\CurrencyRate;

/**
 * CurrencyRateInterface defines the contract for any currency rate service.
 */
interface CurrencyRateInterface
{
    /**
     * Get the daily exchange rate for a given currency relative to the base currency (e.g., USD).
     *
     * @param string $currency - The three-letter ISO 4217 currency code (e.g., 'EUR', 'GBP', 'JPY').
     *
     * @return float - The exchange rate for the specified currency relative to the base currency.
     *                 For example, if $currency is 'GBP' and the base currency is 'USD', this method
     *                 might return 1.12, indicating 1 EUR = 1.12 USD.
     */
    public function getDailyRate(string $currency): float;
}
