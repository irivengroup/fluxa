<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Infrastructure\Extension\ExtensionRegistry;
use Iriven\Fluxa\Infrastructure\Registry\InMemoryFieldTypeRegistry;
use Iriven\Fluxa\Infrastructure\Registry\InMemoryFormTypeRegistry;
use Iriven\Fluxa\Infrastructure\Registry\PluginRegistry;
use Iriven\Fluxa\Tests\Fixtures\Plugin\DemoPlugin;
use PHPUnit\Framework\TestCase;

final class PluginContractCompatibilityTest extends TestCase
{
    public function testLegacyPluginContractRemainsCompatibleWithRegistry(): void
    {
        $registry = new PluginRegistry(
            new InMemoryFieldTypeRegistry(),
            new InMemoryFormTypeRegistry(),
            new ExtensionRegistry(),
        );

        $registry->registerPlugin(new DemoPlugin());

        self::assertCount(1, $registry->all());
    }
}
