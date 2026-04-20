<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Tests;

use Iriven\PhpFormGenerator\Application\Frontend\AdvancedUiComponentResolver;
use Iriven\PhpFormGenerator\Application\Frontend\UiComponentMap;
use Iriven\PhpFormGenerator\Application\Frontend\UiComponentResolver;
use PHPUnit\Framework\TestCase;

final class UiComponentResolutionEdgeCaseTest extends TestCase
{
    public function testEmptyOverrideFallsBackToSafeDefault(): void
    {
        $resolver = new AdvancedUiComponentResolver(
            new UiComponentResolver(),
            new UiComponentMap(['TextType' => ''])
        );

        self::assertSame('input:text', $resolver->resolve('TextType'));
    }

    public function testFullyQualifiedAndShortNameOverridesAreSupported(): void
    {
        $resolver = new AdvancedUiComponentResolver(
            new UiComponentResolver(),
            new UiComponentMap(['TextType' => 'ui.text.short'])
        );

        self::assertSame('ui.text.short', $resolver->resolve('Iriven\PhpFormGenerator\Domain\Field\TextType'));
    }
}
