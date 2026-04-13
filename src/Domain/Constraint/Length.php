<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Domain\Constraint;

use Iriven\PhpFormGenerator\Domain\Contract\ConstraintInterface;

final class Length implements ConstraintInterface
{
    public function __construct(
        private readonly ?int $min = null,
        private readonly ?int $max = null,
    ) {
    }

    public function validate(mixed $value, array $context = []): array
    {
        if ($value === null) {
            return [];
        }

        $length = mb_strlen((string) $value);
        $errors = [];

        if ($this->min !== null && $length < $this->min) {
            $errors[] = sprintf('This value is too short. Minimum is %d characters.', $this->min);
        }

        if ($this->max !== null && $length > $this->max) {
            $errors[] = sprintf('This value is too long. Maximum is %d characters.', $this->max);
        }

        return $errors;
    }
}
