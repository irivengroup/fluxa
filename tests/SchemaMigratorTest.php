<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\Schema\Migration\V20ToV21SchemaMigration;
use Iriven\Fluxa\Application\Schema\SchemaMigrator;
use PHPUnit\Framework\TestCase;

final class SchemaMigratorTest extends TestCase
{
    public function testSchemaCanMigrateFrom20To21(): void
    {
        $schema = (new SchemaMigrator([new V20ToV21SchemaMigration()]))->migrate(['schema' => ['version' => '2.0']], '2.1');
        self::assertSame('2.1', $schema['schema']['version']);
        self::assertSame('2.0', $schema['schema']['migrated_from']);
    }
}
