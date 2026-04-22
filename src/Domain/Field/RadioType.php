<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Domain\Field;

class RadioType extends AbstractFieldType
{
    public static function htmlType(): string
    {
        return 'radio';
    }
}
