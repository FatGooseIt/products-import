<?php

declare(strict_types=1);

namespace App\Tests\unit\Services\FileReader;

use App\Infrastructure\Service\FileReader\FileTypes\Csv\CsvReader;
use App\Infrastructure\Service\FileReader\FileTypes\Csv\CsvReaderIterator;
use PHPUnit\Framework\TestCase;

class CsvReaderTest extends TestCase
{
    private const array VALID_DATA = [
        ['Header1', 'Header2', 'Header3'], // Header
        ['Value1', 'Value2', 'Value3'],
        ['Value4', 'Value5', 'Value6'],
        ['Value7', 'Value8', 'Value9'],
        ['Value10', 'Value11', 'Value12'],
        ['Value13', 'Value14', 'Value15'],
    ];

    private const array INVALID_DATA = [
        ['Header1', 'Header2', 'Header3'], // Header
        ['Value1', 'Value2', 'Value3'],    // Valid row
        ['Value4', 'Value5'],              // Invalid row
        ['Value7', 'Value8', 'Value9'],    // Invalid row
    ];

    private string $testCorrectFilePath;
    private string $testIncorrectFilePath;
    private string $testEmptyFilePath;

    protected function setUp(): void
    {
        // Temporary correct file creation
        $this->testCorrectFilePath = sys_get_temp_dir() . '/test_file_correct.csv';
        $file = fopen($this->testCorrectFilePath, 'wb');
        foreach (self::VALID_DATA as $row) {
            fputcsv($file, $row);
        }
        fclose($file);

        // Temporary incorrect file creation
        $this->testIncorrectFilePath = sys_get_temp_dir() . '/test_file_incorrect.csv';
        $file = fopen($this->testIncorrectFilePath, 'wb');
        foreach (self::INVALID_DATA as $row) {
            fputcsv($file, $row);
        }
        fclose($file);

        // Temporary empty file creation
        $this->testEmptyFilePath = sys_get_temp_dir() . '/test_file_empty.csv';
        $file = fopen($this->testEmptyFilePath, 'wb');
        fclose($file);
    }

    protected function tearDown(): void
    {
        // Delete correct file
        if (file_exists($this->testCorrectFilePath)) {
            unlink($this->testCorrectFilePath);
        }

        // Delete incorrect file
        if (file_exists($this->testIncorrectFilePath)) {
            unlink($this->testIncorrectFilePath);
        }

        // Delete empty file
        if (file_exists($this->testEmptyFilePath)) {
            unlink($this->testEmptyFilePath);
        }
    }

    public function testReadHandlerValidFile(): void
    {
        $iterator = new CsvReaderIterator($this->testCorrectFilePath);
        $reader = new CsvReader($iterator);

        $result = [];
        foreach ($reader->read() as $batch) {
            $result += $batch;
        }

        $expected = [
            ['Header1' => 'Value1', 'Header2' => 'Value2', 'Header3' => 'Value3'],
            ['Header1' => 'Value4', 'Header2' => 'Value5', 'Header3' => 'Value6'],
            ['Header1' => 'Value7', 'Header2' => 'Value8', 'Header3' => 'Value9'],
            ['Header1' => 'Value10', 'Header2' => 'Value11', 'Header3' => 'Value12'],
            ['Header1' => 'Value13', 'Header2' => 'Value14', 'Header3' => 'Value15'],
        ];

        $this->assertEquals($expected, $result);
    }

    public function testReadHandlesInvalidFile(): void
    {
        $iterator = new CsvReaderIterator($this->testIncorrectFilePath);
        $reader = new CsvReader($iterator);

        $result = [];
        foreach ($reader->read() as $batch) {
            $result += $batch;
        }

        $expected = [
            ['Header1' => 'Value1', 'Header2' => 'Value2', 'Header3' => 'Value3'],
            ['Header1' => 'Value7', 'Header2' => 'Value8', 'Header3' => 'Value9'],
        ];

        $this->assertEquals($expected, $result);
    }

    public function testReadHandlesEmptyFile(): void
    {
        $iterator = new CsvReaderIterator($this->testEmptyFilePath);
        $reader = new CsvReader($iterator);

        $result = [];
        foreach ($reader->read() as $batch) {
            $result += $batch;
        }

        $this->assertEmpty($result);
    }
}
