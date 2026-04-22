<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\FormThemeKernel;
use Iriven\Fluxa\Presentation\Html\HtmlRenderer;
use Iriven\Fluxa\Presentation\Html\HtmlRendererFactory;
use PHPUnit\Framework\TestCase;

final class ThemeFallbackRegressionTest extends TestCase
{
    public function testNullThemeAliasReturnsDefaultRenderer(): void
    {
        $renderer = (new HtmlRendererFactory(new FormThemeKernel()))->create(null);
        self::assertInstanceOf(HtmlRenderer::class, $renderer);
    }

    public function testMissingThemeAliasReturnsDefaultRenderer(): void
    {
        $renderer = (new HtmlRendererFactory(new FormThemeKernel()))->create('missing-theme');
        self::assertInstanceOf(HtmlRenderer::class, $renderer);
    }
}
