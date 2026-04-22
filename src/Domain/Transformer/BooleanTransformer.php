<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Domain\Transformer;

use Iriven\Fluxa\Domain\Contract\DataTransformerInterface;

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
