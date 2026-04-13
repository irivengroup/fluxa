<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Infrastructure\Http;

use Iriven\PhpFormGenerator\Domain\Contract\RequestInterface;

final class ArrayRequest implements RequestInterface
{
    public function __construct(private readonly string $method = 'GET', private readonly array $data = [])
    {
    }

    public function getMethod(): string
    {
        return strtoupper($this->method);
    }

    public function all(): array
    {
        return $this->data;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->data[$key] ?? $default;
    }
}
