<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\FileReader\FileTypes\Csv;

use App\Infrastructure\Service\FileReader\Interfaces\FileReaderInterface;
use App\Infrastructure\Service\FileReader\Interfaces\FileReaderIteratorInterface;

/**
 * CsvReader is responsible for reading a CSV file and processing its data in batches.
 */
final class CsvReader implements FileReaderInterface
{
    public const string BATCH_SIZE = '10';

    // This property stores the header row of the CSV file.
    private array $header = [];

    public function __construct(
        private readonly FileReaderIteratorInterface $iterator,
    ) {
    }

    /**
     * Reads the CSV file row by row, groups the data into batches, and yields each batch.
     *
     * @return \Iterator Yields an array of associative arrays.
     *
     * @throws \Exception If the CSV file is empty or improperly formatted.
     */
    public function read(): \Iterator
    {
        $batch = [];
        foreach ($this->iterator as $key => $row) {
            if ($key === 0) {
                if ($row === false || count($row) < 1) {
                    throw new \Exception('CSV file is empty');
                }

                $this->header = $row;

                continue;
            }

            if (count($this->header) !== count($row)) {
                continue;
            }

            $batch[] = array_combine($this->header, $row);

            if (count($batch) >= self::BATCH_SIZE) {
                yield ($batch);
                $batch = [];
            }
        }

        yield $batch;
    }
}
