<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Domain\Transformer;

use Iriven\PhpFormGenerator\Domain\Contract\DataTransformerInterface;

final class StringTrimTransformer implements DataTransformerInterface
{
    public function transform(mixed $value): mixed
    {
        return is_string($value) ? trim($value) : $value;
    }

    public function reverseTransform(mixed $value): mixed
    {
        return is_string($value) ? trim($value) : $value;
    }
}
