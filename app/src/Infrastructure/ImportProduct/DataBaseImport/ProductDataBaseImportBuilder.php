<?php

declare(strict_types=1);

namespace App\Infrastructure\ImportProduct\DataBaseImport;

use App\Domain\TblProductData\Model\TblProductData;
use App\Infrastructure\Service\DataBaseImport\DataBaseImportBuilderInterface;
use App\Infrastructure\Service\DataBaseImport\DbImportDto;

final readonly class ProductDataBaseImportBuilder implements DataBaseImportBuilderInterface
{
    public function getTableName(): string
    {
        return TblProductData::TABLE_NAME;
    }

    /** ProductDto $importDto */
    public function getParams(DbImportDto $importDto): array
    {
        return [
            'strProductName' => $importDto->productName,
            'strProductDesc' => $importDto->productDescription,
            'strProductCode' => $importDto->productCode,
            'dtmAdded' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
            'dtmDiscontinued' => $importDto->discontinuedDate?->format('Y-m-d H:i:s'),
            'stock' => $importDto->stock,
            'costGbp' => $importDto->costGbp,
        ];
    }

    public function getValues(): array
    {
        return [
            'strProductName' => ':strProductName',
            'strProductDesc' => ':strProductDesc',
            'strProductCode' => ':strProductCode',
            'dtmAdded' => ':dtmAdded',
            'dtmDiscontinued' => ':dtmDiscontinued',
            'stock' => ':stock',
            'costGbp' => ':costGbp',
        ];
    }

    public function getUniqueField(): ?string
    {
        return 'strProductCode';
    }
}
