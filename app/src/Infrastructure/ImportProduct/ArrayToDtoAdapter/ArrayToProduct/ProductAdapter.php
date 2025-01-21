<?php

declare(strict_types=1);

namespace App\Infrastructure\ImportProduct\ArrayToDtoAdapter\ArrayToProduct;

use App\Infrastructure\ImportProduct\Dto\ProductDto;
use App\Infrastructure\Service\ArrayToDtoAdapter\ArrayToDtoAdapterDataNormalizer;
use App\Infrastructure\Service\ArrayToDtoAdapter\ArrayToDtoAdapterDtoInterface;
use App\Infrastructure\Service\ArrayToDtoAdapter\ArrayToDtoAdapterInterface;
use App\Infrastructure\Service\Currency\CurrencyConverter\CurrencyConvertorInterface;

final class ProductAdapter extends ArrayToDtoAdapterDataNormalizer implements ArrayToDtoAdapterInterface
{
    private const string  CURRENCY_GBP = 'GBP';

    public function __construct(
        private readonly CurrencyConvertorInterface $currencyConvertor,
    ) {
    }

    /**
     * Adapts raw data into a ProductDto instance.
     *
     * @param array $data Raw associative array containing product data.
     * @return ProductDto The adapted ProductDto.
     */
    public function adapt(array $data): ArrayToDtoAdapterDtoInterface
    {
        return new ProductDto(
            productCode: (string)$data['Product Code'],
            productName: (string)$data['Product Name'],
            productDescription: (string)$data['Product Description'],
            stock: $this->normalizeStringToInt($data['Stock']),
            costGbp: $costGbp = $this->normalizeStringToFloat($data['Cost in GBP']),
            costUsd: $this->currencyConvertor->convertToUSD($costGbp, self::CURRENCY_GBP),
            isDiscontinued: $isDiscontinued = $this->isDiscontinued($data['Discontinued']),
            discontinuedDate: $isDiscontinued ? new \DateTimeImmutable() : null,
        );
    }

    /**
     * Determines if the product is discontinued based on the string value.
     *
     * @param string|null $discontinued The value to check (e.g., "yes").
     * @return bool
     */
    private function isDiscontinued(?string $discontinued): bool
    {
        return strcasecmp($discontinued ?? '', 'yes') === 0;
    }
}
