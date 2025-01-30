<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\FileReader\FileTypes\Csv;

use App\Infrastructure\Service\FileReader\Interfaces\FileReaderIteratorInterface;

/**
 * CsvReaderIterator is responsible for iterating over the rows of a CSV file.
 */
final class CsvReaderIterator implements \Iterator, FileReaderIteratorInterface
{
    private $file;

    private $key;

    private $currentLine;

    public function __construct(string $filePath)
    {
        $this->file = fopen($filePath, 'rb');
        if ($this->file === false) {
            throw new \RuntimeException("Cannot open file: $filePath");
        }
        $this->rewind();
    }

    /**
     * Return the current element.
     *
     * @return array The current row data.
     */
    public function current(): array
    {
        return $this->currentLine;
    }

    /**
     * Return the key of the current element
     *
     * @return int The current row index.
     */
    public function key(): int
    {
        return $this->key;
    }

    /**
     * Move forward to next element
     */
    public function next(): void
    {
        $this->currentLine = fgetcsv($this->file);
        $this->key++;
    }

    /**
     * Rewind the Iterator to the first element.
     */
    public function rewind(): void
    {
        rewind($this->file);
        $this->key = 0;
        $this->currentLine = fgetcsv($this->file); // Read the header
    }

    /**
     * Checks if current position is valid
     *
     * @return bool
     * Returns true on success or false on failure.
     */
    public function valid(): bool
    {
        return $this->currentLine !== false;
    }

    /**
     * Destructor method.
     */
    public function __destruct()
    {
        fclose($this->file);
    }
}
