<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Domain\Contract;

interface RequestInterface
{
    public function getMethod(): string;

    public function all(): array;

    public function get(string $key, mixed $default = null): mixed;
}
