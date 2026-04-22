<?php
declare(strict_types=1);
namespace Iriven\Fluxa\Tests;
use Iriven\Fluxa\Application\Rendering\ThemeDefinition;
use Iriven\Fluxa\Application\Rendering\ThemeRegistry;
use Iriven\Fluxa\Application\Rendering\ThemeResolver;
use PHPUnit\Framework\TestCase;
final class ThemeFallbackTest extends TestCase
{
    public function testUnknownThemeFallsBackWithoutCrash(): void
    {
        $resolver = new ThemeResolver(new ThemeRegistry([new ThemeDefinition('default')]));
        self::assertSame('default', $resolver->resolve('missing'));
    }
}
