<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\FileReader\Interfaces;

interface FileReaderInterface
{
    public function read(): \Iterator;
}
