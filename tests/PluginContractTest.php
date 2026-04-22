<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Domain\Contract\FieldExtensionInterface;
use Iriven\Fluxa\Domain\Contract\PluginInterface;
use PHPUnit\Framework\TestCase;

final class PluginContractTest extends TestCase
{
    public function testPluginContractsExist(): void
    {
        self::assertTrue(interface_exists(PluginInterface::class));
        self::assertTrue(interface_exists(FieldExtensionInterface::class));
    }
}
