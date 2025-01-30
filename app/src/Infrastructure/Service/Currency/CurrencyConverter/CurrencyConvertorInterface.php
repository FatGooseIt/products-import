<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Currency\CurrencyConverter;

/**
 * CurrencyConvertorInterface defines the contract for any currency converter service.
 */
interface CurrencyConvertorInterface
{
    /**
     * Convert a given amount from the specified currency to USD.
     *
     * @param float $amount - The amount in the source currency to be converted.
     * @param string $currency - The currency of the provided amount (e.g. 'GBP').
     *
     * @return float - The equivalent amount in USD after conversion.
     */
    public function convertToUSD(float $amount, string $currency): float;
}
