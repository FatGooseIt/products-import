<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\DataBaseImport;

/**
 * Defines the contract for importing data into a database.
 */
interface DataBaseImportInterface
{
    /**
     * Inserts data into a database table using the specified builder and DTO.
     *
     * @param DataBaseImportBuilderInterface $importBuilder An instance of a builder
     * @param DbImportDto $importDto The Data Transfer Object (DTO) containing the data to be inserted.
     *
     * @return int
     */
    public function insert(DataBaseImportBuilderInterface $importBuilder, DbImportDto $importDto): int;
}
