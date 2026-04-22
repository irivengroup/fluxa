<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Domain\Contract\PluginInterface;
use Iriven\Fluxa\Tests\Fixtures\Plugin\DemoPlugin;
use Iriven\Fluxa\Tests\Fixtures\Plugin\EmptyPlugin;
use Iriven\Fluxa\Tests\Fixtures\Plugin\OverridePlugin;
use PHPUnit\Framework\TestCase;

final class PluginInterfaceSignatureRegressionTest extends TestCase
{
    public function testProjectPluginFixturesImplementPluginInterface(): void
    {
        self::assertInstanceOf(PluginInterface::class, new DemoPlugin());
        self::assertInstanceOf(PluginInterface::class, new EmptyPlugin());
        self::assertInstanceOf(PluginInterface::class, new OverridePlugin());
    }
}
