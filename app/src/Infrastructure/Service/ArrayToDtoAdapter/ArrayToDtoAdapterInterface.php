<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\ArrayToDtoAdapter;

/**
 * Interface for adapting array data into a Data Transfer Object (DTO).
 *
 * This interface ensures that implementing classes provide a mechanism to
 * convert raw associative array data into a structured and typed DTO.
 */
interface ArrayToDtoAdapterInterface
{
    /**
     * Converts an associative array into a DTO.
     *
     * @param array $data The input array containing raw data to be adapted.
     * @return ArrayToDtoAdapterDtoInterface The resulting DTO instance.
     */
    public function adapt(array $data): ArrayToDtoAdapterDtoInterface;
}
