<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Domain\Field;

final class YesNoType extends CountryType
{
    public static function choices(): array { return ['Yes' => '1', 'No' => '0']; }
}
