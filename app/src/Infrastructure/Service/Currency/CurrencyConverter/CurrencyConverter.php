<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Currency\CurrencyConverter;

use App\Infrastructure\Service\Currency\CurrencyRate\CurrencyRateInterface;

/**
 * CurrencyConverter is responsible for converting an amount from any given currency to USD
 */
final readonly class CurrencyConverter implements CurrencyConvertorInterface
{
    /**
     * The constructor initializes the CurrencyConverter with the required dependency
     * that provides the currency rate data for performing the conversion.
     *
     * @param CurrencyRateInterface $currencyRate - The currency rate provider.
     * This is used to fetch the daily rate of a given currency.
     */
    public function __construct(
        private CurrencyRateInterface $currencyRate,
    ) {
    }

    /**
     * Convert the provided amount from the given currency to USD.
     *
     * @param float $amount - The amount in the source currency that needs to be converted.
     * @param string $currency - The currency of the provided amount.
     * @return float - The converted amount in USD.
     *
     * This method uses the daily exchange rate of the provided currency to convert the amount to USD.
     */
    public function convertToUSD(float $amount, string $currency): float
    {
        return $this->currencyRate->getDailyRate($currency) * $amount;
    }
}
