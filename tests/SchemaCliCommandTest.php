<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\Cli\DebugSchemaVersionCommand;
use Iriven\Fluxa\Application\Cli\MigrateSchemaCommand;
use PHPUnit\Framework\TestCase;

final class SchemaCliCommandTest extends TestCase
{
    public function testDebugSchemaVersionReturnsCurrentVersion(): void
    {
        self::assertSame('2.1', (new DebugSchemaVersionCommand())->run());
    }

    public function testMigrateSchemaReturnsJson(): void
    {
        self::assertNotFalse(json_decode((new MigrateSchemaCommand())->run(), true));
    }
}
