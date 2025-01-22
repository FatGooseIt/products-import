<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\DataBaseImport;

interface DataBaseImportBuilderInterface
{
    public function getTableName(): string;

    public function getValues(): array;

    public function getParams(DbImportDto $importDto): array;

    public function getUniqueField(): ?string;
}
