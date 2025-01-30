<?php

declare(strict_types=1);

namespace App\Tests\unit\Services\ImportReporter;

use App\Infrastructure\Service\ImportReporter\Report;
use PHPUnit\Framework\TestCase;

class ReportTest extends TestCase
{
    public function testAddReportData(): void
    {
        $report = new Report();

        $report->addReportData('First entry.');
        $report->addReportData(' Second entry.');

        $this->assertEquals('First entry. Second entry.', $report->getReport());
    }

    public function testAddReportDataChaining(): void
    {
        $report = new Report();
        $report
            ->addReportData('Chaining entry 1.')
            ->addReportData(' Chaining entry 2.');

        $this->assertEquals('Chaining entry 1. Chaining entry 2.', $report->getReport());
    }

    public function testEmptyReport(): void
    {
        $report = new Report();

        $this->assertEquals('', $report->getReport());
    }
}
