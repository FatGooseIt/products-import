<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\ImportReporter;

/**
 * Represents a report containing structured data.
 * Provides methods to build and retrieve the report content.
 */
final class Report
{
    /** @var string Stores the report content. */
    private string $report = '';

    /**
     * Adds data to the report.
     *
     * @param string $reportData The content to be added to the report.
     * @return self Returns the current Report instance for method chaining.
     */
    public function addReportData(string $reportData): self
    {
        $this->report .= $reportData;

        return $this;
    }

    /**
     * Get the full report content.
     *
     * @return string The concatenated content of the report.
     */
    public function getReport(): string
    {
        return $this->report;
    }
}
