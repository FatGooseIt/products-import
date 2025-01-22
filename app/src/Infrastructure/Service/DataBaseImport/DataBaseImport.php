<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\DataBaseImport;

use Doctrine\DBAL\Connection;

final readonly class DataBaseImport implements DataBaseImportInterface
{
    public function __construct(
        protected Connection $connection,
    ) {
    }

    public function insert(DataBaseImportBuilderInterface $importBuilder, DbImportDto $importDto): int
    {
        $params = $importBuilder->getParams($importDto);

        $qb = $this->connection->createQueryBuilder();
        $qb->insert($importBuilder->getTableName())
            ->values($importBuilder->getValues())
            ->setParameters($params);

        $sql = $qb->getSQL();

        $uniqueField = $importBuilder->getUniqueField();
        if ($uniqueField !== null) {
            $sql .= " ON DUPLICATE KEY UPDATE $uniqueField = VALUES($uniqueField)";
        }

        $inserted = $this->connection->executeStatement($sql, $params);

        if (empty($inserted)) {
            throw new \Exception('Insert failed');
        }

        return $inserted;
    }
}
