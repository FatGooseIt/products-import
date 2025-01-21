<?php

declare(strict_types=1);

namespace App\Infrastructure\ImportProduct\Validator\ValidatorHandler;

use App\Infrastructure\Service\Validator\AbstractValidationHandler;
use App\Infrastructure\Service\Validator\ValidationDtoInterface;

/**
 * Validator for checking minimum cost and stock requirements.
 */
final class CostAndStockValidator extends AbstractValidationHandler
{
    /**
     * Validates the cost and stock of the provided DTO.
     * Throws an exception if the cost is less than $5 and the stock is less than 10.
     *
     * @param ValidationDtoInterface $dto The Data Transfer Object to validate.
     * @return void
     *
     * @throws \Exception
     */
    protected function handle(ValidationDtoInterface $dto): void
    {
        if ($dto->costUsd < 5 && $dto->stock < 10) {
            throw new \Exception('Validation error: Cost must be at more then $5 and stock must be more then 10.');
        }
    }
}
