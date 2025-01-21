<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Validator;

interface DataValidatorInterface
{
    /**
     * Validates the provided DTO.
     *
     * @param ValidationDtoInterface $dto The Data Transfer Object to validate.
     * @return void
     *
     * @throws \Exception If the validation fails.
     */
    public function validate(ValidationDtoInterface $dto): void;
}
