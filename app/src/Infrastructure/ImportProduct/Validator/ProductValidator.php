<?php

declare(strict_types=1);

namespace App\Infrastructure\ImportProduct\Validator;

use App\Infrastructure\ImportProduct\Validator\ValidatorHandler\CostAndStockValidator;
use App\Infrastructure\ImportProduct\Validator\ValidatorHandler\MaxCostValidator;
use App\Infrastructure\Service\Validator\DataValidatorInterface;
use App\Infrastructure\Service\Validator\ValidationDtoInterface;
use App\Infrastructure\Service\Validator\ValidationHandlerInterface;

/**
 * Validator for products using the Chain of Responsibility pattern.
 * Aggregates multiple validation handlers to validate products step by step.
 */
final readonly class ProductValidator implements DataValidatorInterface
{
    private ValidationHandlerInterface $validatorChain;

    public function __construct()
    {
        $initialValidator = new CostAndStockValidator();
        $maxCostValidator = new MaxCostValidator();

        $nextValidator = $initialValidator->setNext($maxCostValidator);

        $this->validatorChain = $nextValidator;
    }

    /**
     * Validates the provided DTO using the configured chain of validators.
     *
     * @param ValidationDtoInterface $dto The DTO to be validated.
     * @return void
     *
     * @throws \Exception If any validation rule fails in the chain.
     */
    public function validate(ValidationDtoInterface $dto): void
    {
        $this->validatorChain->validate($dto);
    }
}
