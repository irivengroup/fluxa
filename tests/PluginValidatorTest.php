<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\Plugin\PluginValidator;
use Iriven\Fluxa\Tests\Fixtures\Plugin\DemoPlugin;
use PHPUnit\Framework\TestCase;

final class PluginValidatorTest extends TestCase
{
    public function testProjectPluginFixturePassesValidation(): void
    {
        (new PluginValidator())->validate(new DemoPlugin());
        self::assertTrue(true);
    }
}
