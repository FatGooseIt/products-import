<?php

declare(strict_types=1);

namespace App\Tests\unit\Services\ImportReporter;

use App\Infrastructure\Service\ImportReporter\ReportBuilder;
use PHPUnit\Framework\TestCase;

class ReportBuilderTest extends TestCase
{
    public function testSetHeader(): void
    {
        $builder = new ReportBuilder();
        $builder->setHeader('Header Section');

        $report = $builder->getReport();
        $this->assertEquals('Header Section', $report->getReport());
    }

    public function testSetBody(): void
    {
        $builder = new ReportBuilder();
        $builder->setBody('Body Section');

        $report = $builder->getReport();
        $this->assertEquals('Body Section', $report->getReport());
    }

    public function testSetFooter(): void
    {
        $builder = new ReportBuilder();
        $builder->setFooter('Footer Section');

        $report = $builder->getReport();
        $this->assertEquals('Footer Section', $report->getReport());
    }

    public function testReportComposition(): void
    {
        $builder = new ReportBuilder();

        $builder->setHeader('Header Section');
        $builder->setBody(' Body Section');
        $builder->setFooter(' Footer Section');

        $report = $builder->getReport();
        $this->assertEquals('Header Section Body Section Footer Section', $report->getReport());
    }

    public function testReset(): void
    {
        $builder = new ReportBuilder();

        $builder->setHeader('Initial Header');
        $builder->reset();

        $report = $builder->getReport();
        $this->assertEquals('', $report->getReport());

        $builder->setHeader('New Header');
        $this->assertEquals('New Header', $report->getReport());
    }
}
