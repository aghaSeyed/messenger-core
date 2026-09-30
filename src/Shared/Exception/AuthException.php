<?php
declare(strict_types=1);

namespace Paya\Shared\Exception;

use Throwable;

class AuthException extends \Exception
{
    public function __construct(string $message = "", int $code = 403, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}