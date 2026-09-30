<?php

declare(strict_types=1);

namespace Paya\Infrastructure\Http;

final class JsonResponse
{
    public static function success(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: *');
        header('Access-Control-Allow-Methods: *');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public static function error(string $message, string $code, int $statusCode = 400): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'message' => $message,
            'code' => $code,
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}

