<?php

declare(strict_types=1);

namespace App\Tests\unit\ImportProduct;

use App\Infrastructure\Service\FileReader\FileTypes\Csv\CsvReader;
use App\Infrastructure\Service\FileReader\FileTypes\Csv\CsvReaderFactory;
use App\Infrastructure\Service\FileReader\FileTypes\Csv\CsvReaderIterator;
use App\Infrastructure\Service\FileReader\Interfaces\FileReaderIteratorInterface;
use PHPUnit\Framework\TestCase;

class ProductImportFactoryTest extends TestCase
{
    public function testCreateFileReader()
    {
        $iteratorMock = $this->createMock(FileReaderIteratorInterface::class);

        $factory = new CsvReaderFactory();
        $fileReader = $factory->createFileReader($iteratorMock);

        $this->assertInstanceOf(CsvReader::class, $fileReader);
    }

    public function testCreateFileIterator()
    {
        $filePath = sys_get_temp_dir() . '/test_file_correct.csv';;

        $file = fopen($filePath, 'wb');
        fclose($file);

        $factory = new CsvReaderFactory();
        $fileIterator = $factory->createFileIterator($filePath);

        $this->assertInstanceOf(CsvReaderIterator::class, $fileIterator);

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
