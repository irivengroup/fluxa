<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Domain\Field;

class CountryType extends AbstractFieldType
{
    public static function htmlType(): string { return 'select'; }

    public static function choices(): array
    {
        return [
            'France' => 'FR',
            'Germany' => 'DE',
            'Spain' => 'ES',
            'Italy' => 'IT',
            'United Kingdom' => 'GB',
            'United States' => 'US',
            'Canada' => 'CA',
            'Japan' => 'JP',
        ];
    }
}
