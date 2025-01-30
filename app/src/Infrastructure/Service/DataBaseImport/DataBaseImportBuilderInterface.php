<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\DataBaseImport;

/**
 * Provides the blueprint for building database import queries dynamically.
 */
interface DataBaseImportBuilderInterface
{
    /**
     * Retrieves the name of the target database table.
     *
     * @return string The name of the table where data will be inserted.
     */
    public function getTableName(): string;

    /**
     * Retrieves an associative array of column-value mappings for the SQL query.
     *
     * @return array
     */
    public function getValues(): array;

    /**
     * Generates the parameters to bind to the query placeholders.
     *
     * @param DbImportDto $importDto The DTO containing the data to be inserted.
     *
     * @return array
     */
    public function getParams(DbImportDto $importDto): array;

    /**
     * Retrieves the name of the unique field for the ON DUPLICATE KEY UPDATE clause.
     *
     * @return string|null
     */
    public function getUniqueField(): ?string;
}
