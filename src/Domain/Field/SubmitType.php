<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Domain\Field;

class SubmitType extends AbstractFieldType
{
    public static function htmlType(): string { return 'submit'; }
}
