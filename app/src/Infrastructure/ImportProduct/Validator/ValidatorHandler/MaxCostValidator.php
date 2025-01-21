<?php

declare(strict_types=1);

namespace App\Infrastructure\ImportProduct\Validator\ValidatorHandler;

use App\Infrastructure\Service\Validator\AbstractValidationHandler;
use App\Infrastructure\Service\Validator\ValidationDtoInterface;

/**
 * Validator for checking max cost.
 */
final class MaxCostValidator extends AbstractValidationHandler
{
    /**
     * Validates the cost of the provided DTO.
     * Throws an exception if the cost is over than $5.
     *
     * @param ValidationDtoInterface $dto The Data Transfer Object to validate.
     * @return void
     *
     * @throws \Exception
     */
    protected function handle(ValidationDtoInterface $dto): void
    {
        if ($dto->costUsd > 1000) {
            throw new \Exception('Validation error: Cost must not exceed $1000.');
        }
    }
}
