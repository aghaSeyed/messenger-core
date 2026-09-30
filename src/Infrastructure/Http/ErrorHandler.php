<?php

declare(strict_types=1);

namespace Paya\Infrastructure\Http;

use Paya\Shared\Exception\AuthException;
use Paya\Shared\Exception\DomainException;
use Paya\Shared\Exception\NotFoundException;
use Paya\Shared\Exception\ValidationException;
use Throwable;

final class ErrorHandler
{
    public static function handle(Throwable $exception): void
    {
        $statusCode = self::getStatusCode($exception);
        $message = $exception->getMessage();
        $code = self::getErrorCode($exception);

        error_log(sprintf(
            '[%s] %s: %s in %s:%d',
            date('Y-m-d H:i:s'),
            get_class($exception),
            $message,
            $exception->getFile(),
            $exception->getLine()
        ));

        JsonResponse::error($message, $code, $statusCode);
    }

    private static function getStatusCode(Throwable $exception): int
    {
        return match (true) {
            $exception instanceof ValidationException => 400,
            $exception instanceof NotFoundException => 404,
            $exception instanceof AuthException => 401,
            default => 500,
        };
    }

    private static function getErrorCode(Throwable $exception): string
    {
        if ($exception instanceof DomainException) {
            return $exception->getErrorCode();
        }

        if ($exception instanceof AuthException) {
            return "Access Denied!";
        }

        return 'INTERNAL_ERROR';
    }
}

