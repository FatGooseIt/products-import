<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\DataBaseImport;

use App\Infrastructure\Service\ArrayToDtoAdapter\ArrayToDtoAdapterDtoInterface;

interface DataBaseImportInterface
{
    public function insert(ArrayToDtoAdapterDtoInterface $item): int;
}
