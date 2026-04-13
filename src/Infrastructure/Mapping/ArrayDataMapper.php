<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Infrastructure\Mapping;

final class ArrayDataMapper
{
    public function map(array $target, array $values): array
    {
        foreach ($values as $key => $value) {
            $target[$key] = $value;
        }
        return $target;
    }
}
