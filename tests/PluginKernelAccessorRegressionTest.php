<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\FormPluginKernel;
use Iriven\Fluxa\Infrastructure\Registry\PluginRegistry;
use PHPUnit\Framework\TestCase;

final class PluginKernelAccessorRegressionTest extends TestCase
{
    public function testPluginsAccessorRemainsAvailable(): void
    {
        $kernel = new FormPluginKernel();

        self::assertInstanceOf(PluginRegistry::class, $kernel->plugins());
        self::assertSame($kernel->plugins(), $kernel->registry());
    }
}
