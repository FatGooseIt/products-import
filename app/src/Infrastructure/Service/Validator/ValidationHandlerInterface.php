<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Validator;

/**
 * Interface for validation handlers in the Chain of Responsibility pattern.
 * Defines methods for linking handlers and performing validation.
 */
interface ValidationHandlerInterface
{
    /**
     * Sets the next handler in the chain.
     *
     * @param ValidationHandlerInterface $nextHandler The next validation handler.
     * @return ValidationHandlerInterface Returns the next handler for method chaining.
     */
    public function setNext(ValidationHandlerInterface $nextHandler): ValidationHandlerInterface;

    /**
     * Validates the given DTO by executing the current handler's logic.
     *
     * @param ValidationDtoInterface $dto The Data Transfer Object to validate.
     * @return void
     *
     * @throws \Exception If any validation rule in the chain fails.
     */
    public function validate(ValidationDtoInterface $dto): void;
}
