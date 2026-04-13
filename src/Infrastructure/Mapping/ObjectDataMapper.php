<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Infrastructure\Mapping;

final class ObjectDataMapper
{
    public function map(object $target, array $values): object
    {
        foreach ($values as $key => $value) {
            $target->{$key} = $value;
        }
        return $target;
    }
}
