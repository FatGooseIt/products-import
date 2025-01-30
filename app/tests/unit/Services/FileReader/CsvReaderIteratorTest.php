<?php

declare(strict_types=1);

namespace App\Tests\unit\Services\FileReader;

use App\Infrastructure\Service\FileReader\FileTypes\Csv\CsvReader;
use App\Infrastructure\Service\FileReader\FileTypes\Csv\CsvReaderFactory;
use App\Infrastructure\Service\FileReader\FileTypes\Csv\CsvReaderIterator;
use App\Infrastructure\Service\FileReader\Interfaces\FileReaderIteratorInterface;
use PHPUnit\Framework\TestCase;

class CsvReaderIteratorTest extends TestCase
{
    private const array TEST_DATA = [
        ['Header1', 'Header2', 'Header3'],
        ['Value1', 'Value2', 'Value3'],
        ['Value4', 'Value5', 'Value6'],
    ];

    private string $testCorrectFilePath;

    protected function setUp(): void
    {
        $this->testCorrectFilePath = sys_get_temp_dir() . '/test_file_correct.csv';

        $file = fopen($this->testCorrectFilePath, 'wb');
        foreach (self::TEST_DATA as $row) {
            fputcsv($file, $row);
        }
        fclose($file);
    }

    protected function tearDown(): void
    {
        if (file_exists($this->testCorrectFilePath)) {
            unlink($this->testCorrectFilePath);
        }
    }

    public function testIteratorReadsFileCorrectly(): void
    {
        $iterator = new CsvReaderIterator($this->testCorrectFilePath);

        $result = [];
        foreach ($iterator as $line) {
            $result[] = $line;
        }

        $this->assertEquals(self::TEST_DATA, $result);
    }

    public function testRewindResetsIterator(): void
    {
        $iterator = new CsvReaderIterator($this->testCorrectFilePath);

        $iterator->next();
        $this->assertEquals(['Value1', 'Value2', 'Value3'], $iterator->current());

        $iterator->rewind();
        $this->assertEquals(['Header1', 'Header2', 'Header3'], $iterator->current());
    }

    public function testValidReturnsFalseAtEndOfFile(): void
    {
        $iterator = new CsvReaderIterator($this->testCorrectFilePath);

        while ($iterator->valid()) {
            $iterator->next();
        }

        $this->assertFalse($iterator->valid());
    }


    public function testCreateFileReader()
    {
        $iteratorMock = $this->createMock(FileReaderIteratorInterface::class);

        $factory = new CsvReaderFactory();
        $fileReader = $factory->createFileReader($iteratorMock);

        $this->assertInstanceOf(CsvReader::class, $fileReader);
    }
}
