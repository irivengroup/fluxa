<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\FormPluginKernel;
use Iriven\Fluxa\Tests\Fixtures\Plugin\DemoPlugin;
use PHPUnit\Framework\TestCase;

final class PluginKernelHardeningTest extends TestCase
{
    public function testPluginRegistrationStillWorksWithValidatorEnabled(): void
    {
        $kernel = new FormPluginKernel();
        $kernel->register(new DemoPlugin());

        self::assertCount(1, $kernel->plugins()->all());
    }
}
