<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Validator;

/**
 * Abstract base class for validation handlers in a chain of responsibility.
 * Provides the mechanism to link multiple validation handlers and process a validation chain.
 */
abstract class AbstractValidationHandler implements ValidationHandlerInterface
{
    private ?ValidationHandlerInterface $nextHandler = null;

    /**
     * Sets the next handler in the chain.
     *
     * @param ValidationHandlerInterface $nextHandler The next validation handler.
     * @return ValidationHandlerInterface Returns the next handler for method chaining.
     */
    public function setNext(ValidationHandlerInterface $nextHandler): ValidationHandlerInterface
    {
        $this->nextHandler = $nextHandler;

        return $nextHandler;
    }

    /**
     * Validates the given DTO by executing the current handler's logic.
     *
     * @param ValidationDtoInterface $dto The Data Transfer Object to validate.
     * @return void
     *
     * @throws \Exception If any validation rule in the chain fails.
     */
    public function validate(ValidationDtoInterface $dto): void
    {
        $this->handle($dto);

        if ($this->nextHandler !== null) {
            $this->nextHandler->validate($dto);
        }
    }

    /**
     * Defines the specific validation logic for the current handler.
     *
     * @param ValidationDtoInterface $dto The Data Transfer Object to validate.
     * @return void
     *
     * @throws \Exception If the validation fails.
     */
    abstract protected function handle(ValidationDtoInterface $dto): void;
}
