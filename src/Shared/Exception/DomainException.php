<?php

declare(strict_types=1);

namespace Paya\Shared\Exception;

use Exception;

class DomainException extends Exception
{
    public function __construct(string $message, string $code = 'DOMAIN_ERROR')
    {
        parent::__construct($message, 0);
        $this->code = $code;
    }

    public function getErrorCode(): string
    {
        return (string) $this->code;
    }
}

