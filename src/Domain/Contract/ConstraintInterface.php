<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Domain\Contract;

interface ConstraintInterface
{
    /**
     * @param array<string, mixed> $context
     * @return list<string>
     */
    public function validate(mixed $value, array $context = []): array;
}
