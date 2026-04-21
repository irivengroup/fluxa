<?php
declare(strict_types=1);
namespace Iriven\PhpFormGenerator\Tests;
use Iriven\PhpFormGenerator\Application\Rendering\ThemeDefinition;
use Iriven\PhpFormGenerator\Application\Rendering\ThemeRegistry;
use Iriven\PhpFormGenerator\Application\Rendering\ThemeResolver;
use PHPUnit\Framework\TestCase;
final class ThemeFallbackTest extends TestCase
{
    public function testUnknownThemeFallsBackWithoutCrash(): void
    {
        $resolver = new ThemeResolver(new ThemeRegistry([new ThemeDefinition('default')]));
        self::assertSame('default', $resolver->resolve('missing'));
    }
}
