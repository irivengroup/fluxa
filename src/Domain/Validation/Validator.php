<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Domain\Validation;

use Iriven\PhpFormGenerator\Domain\Contract\ConstraintInterface;

final class Validator
{
    /** @param list<ConstraintInterface> $constraints */
    public function validate(mixed $value, array $constraints): array
    {
        $errors = [];
        foreach ($constraints as $constraint) {
            foreach ($constraint->validate($value) as $error) {
                $errors[] = $error;
            }
        }
        return $errors;
    }
}
