<?php

declare(strict_types=1);

namespace Paya\Infrastructure\Http;

final class Request
{
    public array $pathParameters = [];

    public function __construct(
        private readonly array  $server,
        private readonly string $rawBody
    )
    {
    }

    public static function fromGlobals(): self
    {
        return new self(
            $_SERVER,
            file_get_contents('php://input') ?: ''
        );
    }

    public function getMethod(): string
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
    }

    public function getUri(): string
    {
        $uri = $this->server['REQUEST_URI'] ?? '/';

        if (($pos = strpos($uri, '?')) !== false) {
            $uri = substr($uri, 0, $pos);
        }

        return $uri;
    }

    public function getJsonBody(): array
    {
        if (empty($this->rawBody)) {
            return [];
        }

        $decoded = json_decode($this->rawBody, true);

        return $decoded ?? [];
    }

    public function getParams(): array
    {
        return $_GET;
    }

    public function setPathParameters(array $parameters): void
    {
        $this->pathParameters = $parameters;
    }

    public function getPathParameter(string $key): ?string
    {
        return $this->pathParameters[$key] ?? null;
    }
}
