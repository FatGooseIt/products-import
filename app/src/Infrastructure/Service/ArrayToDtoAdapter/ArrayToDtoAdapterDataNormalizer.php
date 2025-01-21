<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\ArrayToDtoAdapter;

/**
 * Normalizer for adapting array data into a Data Transfer Object (DTO).
 */
abstract class ArrayToDtoAdapterDataNormalizer
{
    /**
     * Normalize a string to a float value.
     *
     * - Removes all non-numeric characters except for `.` and `,`.
     * - Converts `,` to `.` for compatibility with float format.
     * - Returns 0.0 if the string is null or empty.
     *
     * @param string|null $string The input string to normalize.
     * @return float The normalized float value.
     */
    protected function normalizeStringToFloat(?string $string): float
    {
        $string = !empty($string) ? preg_replace('/[^0-9.,]/', '', $string) : 0.0;

        if (is_float($string)) {
            return $string;
        }

        return (float)str_replace(',', '.', $string);
    }

    /**
     * Normalize a string to an integer value.
     *
     * - Removes all non-numeric characters.
     * - Returns 0 if the string is null or empty.
     *
     * @param string|null $string The input string to normalize.
     * @return int The normalized integer value.
     */
    protected function normalizeStringToInt(?string $string): int
    {
        return !empty($string) ? (int)preg_replace('/[^0-9]/', '', $string) : 0;
    }
}
