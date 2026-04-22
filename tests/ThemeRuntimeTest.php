<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\FormThemeKernel;
use Iriven\Fluxa\Presentation\Html\HtmlRenderer;
use Iriven\Fluxa\Presentation\Html\HtmlRendererFactory;
use PHPUnit\Framework\TestCase;

final class ThemeRuntimeTest extends TestCase
{
    public function testRendererFactoryCanResolveTailwindTheme(): void
    {
        $kernel = new FormThemeKernel();
        $factory = new HtmlRendererFactory($kernel);
        $renderer = $factory->create('tailwind');

        self::assertInstanceOf(HtmlRenderer::class, $renderer);
    }

    public function testRendererFactoryFallsBackToDefaultTheme(): void
    {
        $kernel = new FormThemeKernel();
        $factory = new HtmlRendererFactory($kernel);
        $renderer = $factory->create('unknown-theme');

        self::assertInstanceOf(HtmlRenderer::class, $renderer);
    }
}
