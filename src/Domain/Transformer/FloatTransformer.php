<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Domain\Transformer;

use Iriven\PhpFormGenerator\Domain\Contract\DataTransformerInterface;

final class FloatTransformer implements DataTransformerInterface
{
    public function transform(mixed $value): mixed
    {
        return $value === null || $value === '' ? null : (string) (float) $value;
    }

    public function reverseTransform(mixed $value): mixed
    {
        return $value === null || $value === '' ? null : (float) $value;
    }
}
