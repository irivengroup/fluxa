<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Domain\Constraint;

use Iriven\PhpFormGenerator\Domain\Contract\ConstraintInterface;

final class Choice implements ConstraintInterface
{
    public function __construct(private readonly array $choices)
    {
    }

    public function validate(mixed $value, array $context = []): array
    {
        if ($value === null || $value === '') {
            return [];
        }

        if (is_array($value)) {
            foreach ($value as $item) {
                if (!in_array($item, $this->choices, true)) {
                    return ['One or more choices are invalid.'];
                }
            }
            return [];
        }

        return in_array($value, $this->choices, true) ? [] : ['The selected choice is invalid.'];
    }
}
