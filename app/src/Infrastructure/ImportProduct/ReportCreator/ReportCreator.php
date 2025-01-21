<?php

declare(strict_types=1);

namespace App\Infrastructure\ImportProduct\ReportCreator;

use App\Infrastructure\Service\ImportReporter\Report;
use App\Infrastructure\Service\ImportReporter\ReportBuilderInterface;

final readonly class ReportCreator
{
    private ReportBuilderInterface $reportBuilder;

    public function setBuilder(ReportBuilderInterface $reportBuilder): ReportCreator
    {
        $this->reportBuilder = $reportBuilder;

        return $this;
    }

    public function createProductReport(
        array $failedItems,
        int $read,
        int $inserted,
        int $skipped,
    ): Report {
        $reportBuilder = $this->getReportBuilder();
        $reportBuilder->setHeader("<info>Report:</info>\n");
        foreach ($failedItems as $failedItem) {
            $reportBuilder->setBody("<fg=red> Failed: </fg=red> $failedItem \n");
        }
        $reportBuilder->setBody("<info>READED: $read</info>\n");
        $reportBuilder->setBody("<info>INSERTED: $inserted</info>\n");
        $reportBuilder->setBody("<info>SKIPPED: $skipped</info>\n");
        $reportBuilder->setFooter("<info>Finished</info>\n");

        return $reportBuilder->getReport();
    }

    public function getReportBuilder(): ReportBuilderInterface
    {
        return $this->reportBuilder;
    }
}
