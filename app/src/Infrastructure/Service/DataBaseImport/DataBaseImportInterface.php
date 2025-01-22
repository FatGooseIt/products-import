<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\DataBaseImport;

interface DataBaseImportInterface
{
    public function insert(DataBaseImportBuilderInterface $importBuilder, DbImportDto $importDto): int;
}
