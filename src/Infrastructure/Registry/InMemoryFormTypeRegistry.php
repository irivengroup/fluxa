<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Infrastructure\Registry;

use Iriven\PhpFormGenerator\Domain\Contract\FormTypeRegistryInterface;

final class InMemoryFormTypeRegistry implements FormTypeRegistryInterface
{
    /** @var array<string, string> */
    private array $types = [];

    /**
     * @param array<string, string> $initial
     */
    public function __construct(array $initial = [])
    {
        foreach ($initial as $alias => $typeClass) {
            $this->register($alias, $typeClass);
        }
    }

    public function register(string $alias, string $typeClass): void
    {
        $this->types[strtolower(trim($alias))] = $typeClass;
    }

    public function has(string $alias): bool
    {
        return array_key_exists(strtolower(trim($alias)), $this->types);
    }

    public function resolve(string $alias): ?string
    {
        return $this->types[strtolower(trim($alias))] ?? null;
    }

    /**
     * @return array<string, string>
     */
    public function all(): array
    {
        return $this->types;
    }
}
