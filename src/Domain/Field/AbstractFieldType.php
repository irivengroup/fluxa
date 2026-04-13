<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Domain\Field;

abstract class AbstractFieldType
{
    public static function htmlType(): string
    {
        return 'text';
    }
}
