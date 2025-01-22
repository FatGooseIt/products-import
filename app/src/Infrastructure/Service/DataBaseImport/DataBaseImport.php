<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\DataBaseImport;

use Doctrine\DBAL\Connection;

/**
 * Handles the insertion of data into a database.
 */
final readonly class DataBaseImport implements DataBaseImportInterface
{
    public function __construct(
        protected Connection $connection,
    ) {
    }

    /**
     * Inserts data into the database.
     *
     * @param DataBaseImportBuilderInterface $importBuilder An implementation of a builder interface.
     * @param DbImportDto $importDto The DTO containing the data to be inserted.
     *
     * @return int The number of rows inserted to the table.
     *
     * @throws \Exception If the insert operation fails.
     */
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
