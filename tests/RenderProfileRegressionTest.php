<?php
declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\Rendering\RenderProfile;
use Iriven\Fluxa\Application\Rendering\RenderProfileManager;
use Iriven\Fluxa\Application\Rendering\RenderingChannel;
use Iriven\Fluxa\Application\Rendering\ThemeDefinition;
use Iriven\Fluxa\Application\Rendering\ThemeRegistry;
use Iriven\Fluxa\Application\Rendering\ThemeResolver;
use PHPUnit\Framework\TestCase;

final class RenderProfileRegressionTest extends TestCase
{
    public function testEmptyThemeFallsBackToDefault(): void
    {
        self::assertSame('default', (new RenderProfile(''))->theme());
    }

    public function testEmptyChannelFallsBackToHtml(): void
    {
        self::assertSame(RenderingChannel::HTML, (new RenderProfile('default', ''))->channel());
    }

    public function testEmptyMetadataRemainsArray(): void
    {
        $manager = new RenderProfileManager(new ThemeResolver(new ThemeRegistry([new ThemeDefinition('default')])));
        $data = $manager->export(new RenderProfile('default', RenderingChannel::HEADLESS, []));

        self::assertIsArray($data['metadata']);
        self::assertSame([], $data['metadata']);
    }
}
