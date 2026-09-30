<?php

declare(strict_types=1);

namespace Paya\Shared\Exception;

final class ValidationException extends DomainException
{
    public function __construct(string $message = 'Validation failed')
    {
        parent::__construct($message, 'VALIDATION_ERROR');
    }

    public static function invalidField(string $fieldName, string $reason): self
    {
        return new self(
            sprintf('Invalid %s: %s', $fieldName, $reason)
        );
    }

    public static function missingField(string $fieldName): self
    {
        return new self(
            sprintf('Missing required field: %s', $fieldName)
        );
    }
}
