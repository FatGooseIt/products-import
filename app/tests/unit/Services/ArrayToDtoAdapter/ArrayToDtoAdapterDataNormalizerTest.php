<?php

declare(strict_types=1);

namespace App\Tests\unit\Services\ArrayToDtoAdapter;

use App\Infrastructure\Service\ArrayToDtoAdapter\ArrayToDtoAdapterDataNormalizer;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ArrayToDtoAdapterDataNormalizerTest extends TestCase
{
    private ArrayToDtoAdapterDataNormalizer $normalizer;
    private \ReflectionMethod $normalizeStringToFloat;
    private \ReflectionMethod $normalizeStringToInt;

    protected function setUp(): void
    {
        $this->normalizer = new class extends ArrayToDtoAdapterDataNormalizer {};

        $reflectionClass = new ReflectionClass(ArrayToDtoAdapterDataNormalizer::class);
        $this->normalizeStringToFloat = $reflectionClass->getMethod('normalizeStringToFloat');
        $this->normalizeStringToInt = $reflectionClass->getMethod('normalizeStringToInt');
    }

    /**
     * @dataProvider normalizeStringToFloatDataProvider
     */
    public function testNormalizeStringToFloat(?string $input, float $expected): void
    {
        $result = $this->normalizeStringToFloat->invoke($this->normalizer, $input);
        $this->assertSame($expected, $result);
    }

    /**
     * @dataProvider normalizeStringToIntDataProvider
     */
    public function testNormalizeStringToInt(?string $input, int $expected): void
    {
        $result = $this->normalizeStringToInt->invoke($this->normalizer, $input);
        $this->assertSame($expected, $result);
    }

    public static function normalizeStringToFloatDataProvider(): array
    {
        return [
            [null, 0.0],
            ['', 0.0],
            ['123.45', 123.45],
            ['123,45', 123.45],
            ['abc123.45xyz', 123.45],
            ['-100.50', 100.50],
        ];
    }

    public static function normalizeStringToIntDataProvider(): array
    {
        return [
            [null, 0],
            ['', 0],
            ['123', 123],
            ['abc123xyz', 123],
            ['12.34', 1234],
            ['0', 0],
            ['1,000', 1000],
        ];
    }
}
