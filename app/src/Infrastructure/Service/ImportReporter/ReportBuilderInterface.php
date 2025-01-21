<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\ImportReporter;

/**
 * Interface for building reports.
 * Defines methods for setting different parts of a report.
 */
interface ReportBuilderInterface
{
    /**
     * Sets the header section of the report.
     *
     * @param string $header The content of the header.
     * @return void
     */
    public function setHeader(string $header): void;

    /**
     * Sets the body section of the report.
     *
     * @param string $body The content of the body.
     * @return void
     */
    public function setBody(string $body): void;

    /**
     * Sets the footer section of the report.
     *
     * @param string $footer The content of the footer.
     * @return void
     */
    public function setFooter(string $footer): void;
}
