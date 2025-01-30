<?php

declare(strict_types=1);

namespace App\Tests\unit\ImportProduct;

use App\Infrastructure\ImportProduct\ArrayToDtoAdapter\ArrayToProduct\ProductAdapter;
use App\Infrastructure\ImportProduct\Dto\ProductDto;
use App\Infrastructure\Service\Currency\CurrencyConverter\CurrencyConvertorInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ProductAdapterTest extends TestCase
{
    private CurrencyConvertorInterface|MockObject $currencyConvertor;
    private ProductAdapter $productAdapter;

    protected function setUp(): void
    {
        $this->currencyConvertor = $this->createMock(CurrencyConvertorInterface::class);
        $this->productAdapter = new ProductAdapter($this->currencyConvertor);
    }

    public function testAdapt(): void
    {
        $data = [
            'Product Code' => 'P123',
            'Product Name' => 'Product Name',
            'Product Description' => 'Description of the product.',
            'Stock' => '100',
            'Cost in GBP' => '10.50',
            'Discontinued' => 'yes'
        ];

        $this->currencyConvertor->expects($this->once())
            ->method('convertToUSD')
            ->with(10.50, 'GBP')
            ->willReturn(14.00);

        $productDto = $this->productAdapter->adapt($data);

        $this->assertInstanceOf(ProductDto::class, $productDto);
        $this->assertEquals('P123', $productDto->productCode);
        $this->assertEquals('Product Name', $productDto->productName);
        $this->assertEquals('Description of the product.', $productDto->productDescription);
        $this->assertEquals(100, $productDto->stock);
        $this->assertEquals(10.50, $productDto->costGbp);
        $this->assertEquals(14.00, $productDto->costUsd);
        $this->assertTrue($productDto->isDiscontinued);
        $this->assertInstanceOf(\DateTimeImmutable::class, $productDto->discontinuedDate);
    }
}
