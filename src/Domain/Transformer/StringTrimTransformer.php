<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Domain\Transformer;

use Iriven\Fluxa\Domain\Contract\DataTransformerInterface;

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
