<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Domain\Transformer;

use Iriven\PhpFormGenerator\Domain\Contract\DataTransformerInterface;

final class BooleanTransformer implements DataTransformerInterface
{
    public function transform(mixed $value): mixed
    {
        return (bool) $value;
    }

    public function reverseTransform(mixed $value): mixed
    {
        if (is_bool($value)) {
            return $value;
        }

        return in_array((string) $value, ['1', 'true', 'on', 'yes'], true);
    }
}
