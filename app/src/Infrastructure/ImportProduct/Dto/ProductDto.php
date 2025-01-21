<?php

declare(strict_types=1);

namespace App\Infrastructure\ImportProduct\Dto;

use App\Infrastructure\Service\ArrayToDtoAdapter\ArrayToDtoAdapterDtoInterface;
use App\Infrastructure\Service\Validator\ValidationDtoInterface;

/**
 * Represents a Data Transfer Object (DTO) for a product.
 */
final readonly class ProductDto implements ArrayToDtoAdapterDtoInterface, ValidationDtoInterface
{
    /**
     * @param string $productCode The unique code of the product.
     * @param string $productName The name of the product.
     * @param string $productDescription The description of the product.
     * @param int $stock The quantity of the product.
     * @param float $costGbp The cost of the product in GBP (British Pounds).
     * @param float $costUsd The cost of the product in USD (United States Dollars).
     * @param bool $isDiscontinued Indicates whether the product is discontinued.
     * @param \DateTimeImmutable|null $discontinuedDate The date when the product was discontinued, if applicable.
     */
    public function __construct(
        public string $productCode,
        public string $productName,
        public string $productDescription,
        public int $stock,
        public float $costGbp,
        public float $costUsd,
        public bool $isDiscontinued,
        public ?\DateTimeImmutable $discontinuedDate,
    ) {
    }
}
