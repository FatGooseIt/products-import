<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\FileReader\Interfaces;

interface FileReaderIteratorInterface
{
    public function current(): array;

    public function key(): int;

    public function next(): void;

    public function valid(): bool;
}
