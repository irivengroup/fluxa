<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Domain\Transformer;

use Iriven\PhpFormGenerator\Domain\Contract\DataTransformerInterface;

final class IntegerTransformer implements DataTransformerInterface
{
    public function transform(mixed $value): mixed
    {
        return $value === null || $value === '' ? null : (string) (int) $value;
    }

    public function reverseTransform(mixed $value): mixed
    {
        return $value === null || $value === '' ? null : (int) $value;
    }
}
