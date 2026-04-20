<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Application\Frontend;

use Throwable;

/**
 * @api
 */
final class AdvancedUiComponentResolver
{
    public function __construct(
        private readonly UiComponentResolver $baseResolver = new UiComponentResolver(),
        private readonly UiComponentMap $componentMap = new UiComponentMap(),
    ) {
    }

    public function resolve(string $fieldType): string
    {
        $default = 'input:text';

        try {
            $default = $this->baseResolver->resolve($fieldType);
        } catch (Throwable) {
            $default = 'input:text';
        }

        $resolved = $this->componentMap->resolve($fieldType, $default);

        return $resolved !== '' ? $resolved : 'input:text';
    }
}
