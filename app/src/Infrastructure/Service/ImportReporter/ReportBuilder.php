<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\ImportReporter;

/**
 * Class responsible for building a report in a structured way.
 * Implements the builder pattern to create and manage Report objects.
 */
final class ReportBuilder implements ReportBuilderInterface
{
    /** @var Report Current Report instance being built. */
    private Report $report;

    public function __construct()
    {
        $this->reset();
    }

    /**
     * Resets the current Report object to a new instance.
     * This allows the builder to start creating a new report.
     *
     * @return void
     */
    public function reset(): void
    {
        $this->report = new Report();
    }

    /**
     * Sets the header section of the report.
     *
     * @param string $header The header content to be added to the report.
     * @return void
     */
    public function setHeader(string $header): void
    {
        $this->report->addReportData($header);
    }

    /**
     * Sets the body section of the report.
     *
     * @param string $body The body content to be added to the report.
     * @return void
     */
    public function setBody(string $body): void
    {
        $this->report->addReportData($body);
    }

    /**
     * Sets the footer section of the report.
     *
     * @param string $footer The footer content to be added to the report.
     * @return void
     */
    public function setFooter(string $footer): void
    {
        $this->report->addReportData($footer);
    }

    /**
     * @return Report The final Report instance.
     */
    public function getReport(): Report
    {
        return $this->report;
    }
}
