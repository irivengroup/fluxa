<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\FormFactory;
use Iriven\Fluxa\Application\FormRuntimeContext;
use PHPUnit\Framework\TestCase;

final class RuntimeContextTest extends TestCase
{
    public function testRuntimeContextExposesFormThemeRendererAndMetadata(): void
    {
        $form = (new FormFactory())->createBuilder('contact')->getForm();
        $context = new FormRuntimeContext($form, 'tailwind', 'RendererClass', ['variant' => 'compact']);

        self::assertSame($form, $context->form());
        self::assertSame('tailwind', $context->theme());
        self::assertSame('RendererClass', $context->renderer());
        self::assertSame(['variant' => 'compact'], $context->metadata());
    }
}
