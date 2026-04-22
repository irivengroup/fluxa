<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Domain\Field;

use Iriven\Fluxa\Domain\Contract\DataTransformerInterface;
use Iriven\Fluxa\Domain\Transformer\IntegerTransformer;

class IntegerType extends NumberType
{
    /** @return array<int, DataTransformerInterface> */
    public static function defaultTransformers(): array
    {
        return [new IntegerTransformer()];
    }
}
