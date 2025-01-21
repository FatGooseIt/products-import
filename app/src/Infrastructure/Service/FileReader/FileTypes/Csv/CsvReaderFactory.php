<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\FileReader\FileTypes\Csv;

use App\Infrastructure\Service\FileReader\AbstractReaderFactoryInterface;
use App\Infrastructure\Service\FileReader\Interfaces\FileReaderInterface;
use App\Infrastructure\Service\FileReader\Interfaces\FileReaderIteratorInterface;

final readonly class CsvReaderFactory implements AbstractReaderFactoryInterface
{
    /**
     * Creates an instance of `CsvReaderIterator` to iterate over the rows of a CSV file.
     *
     * @param string $filePath The path to the CSV file to be read.
     *
     * @return FileReaderIteratorInterface
     */
    public function createFileIterator(string $filePath): FileReaderIteratorInterface
    {
        return new CsvReaderIterator($filePath);
    }

    /**
     * Creates an instance of `CsvReader` to process the CSV data in batches.
     *
     * @param FileReaderIteratorInterface $iterator An iterator that provides access to the rows of the CSV file.
     *
     * @return FileReaderInterface
     */
    public function createFileReader(FileReaderIteratorInterface $iterator): FileReaderInterface
    {
        return new CsvReader($iterator);
    }
}
