<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Domain\Field;

abstract class AbstractFieldType
{
    public static function htmlType(): string
    {
        return 'text';
    }
}
