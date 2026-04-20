<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Tests;

use Iriven\PhpFormGenerator\Application\Schema\SchemaVersionManager;
use PHPUnit\Framework\TestCase;

final class SchemaVersionManagerTest extends TestCase
{
    public function testSchemaVersionIsStamped(): void
    {
        $schema = (new SchemaVersionManager('2.1'))->stamp(['fields' => []]);
        self::assertSame('2.1', $schema['schema']['version']);
    }
}
