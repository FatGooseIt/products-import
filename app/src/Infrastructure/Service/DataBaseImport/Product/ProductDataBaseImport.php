<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\DataBaseImport\Product;

use App\Domain\TblProductData\Model\TblProductData;
use App\Infrastructure\Service\ArrayToDtoAdapter\ArrayToDtoAdapterDtoInterface;
use App\Infrastructure\Service\DataBaseImport\DataBaseImportInterface;
use Doctrine\DBAL\Connection;

final readonly class ProductDataBaseImport implements DataBaseImportInterface
{
    public function __construct(
        protected Connection $connection,
    ) {
    }

    public function insert(ArrayToDtoAdapterDtoInterface $item): int
    {
        $params = [
            'strProductName' => $item->productName,
            'strProductDesc' => $item->productDescription,
            'strProductCode' => $item->productCode,
            'dtmAdded' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
            'dtmDiscontinued' => $item->discontinuedDate?->format('Y-m-d H:i:s'),
            'stock' => $item->stock,
            'costGbp' => $item->costGbp,
        ];

        $qb = $this->connection->createQueryBuilder();
        $qb->insert(TblProductData::TABLE_NAME)
            ->values([
                'strProductName' => ':strProductName',
                'strProductDesc' => ':strProductDesc',
                'strProductCode' => ':strProductCode',
                'dtmAdded' => ':dtmAdded',
                'dtmDiscontinued' => ':dtmDiscontinued',
                'stock' => ':stock',
                'costGbp' => ':costGbp',
            ])
            ->setParameters($params);

        $sql = $qb->getSQL() . ' ON DUPLICATE KEY UPDATE strProductCode = VALUES(strProductCode)';

        $inserted = $this->connection->executeStatement($sql, $params);

        if (empty($inserted)) {
            throw new \Exception('Insert failed');
        }

        return $inserted;
    }
}
