<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\FileReader;


use App\Infrastructure\Service\FileReader\Interfaces\FileReaderInterface;
use App\Infrastructure\Service\FileReader\Interfaces\FileReaderIteratorInterface;

interface AbstractReaderFactoryInterface
{
    public function createFileIterator(string $filePath): FileReaderIteratorInterface;

    public function createFileReader(FileReaderIteratorInterface $iterator): FileReaderInterface;
}
