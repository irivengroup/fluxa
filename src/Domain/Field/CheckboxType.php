<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Domain\Field;

final class CheckboxType extends AbstractFieldType
{
    public static function htmlType(): string { return 'checkbox'; }
}
