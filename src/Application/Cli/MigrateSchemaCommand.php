<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Application\Cli;

use Iriven\PhpFormGenerator\Application\Schema\Migration\V20ToV21SchemaMigration;
use Iriven\PhpFormGenerator\Application\Schema\SchemaMigrator;

/**
 * @api
 */
final class MigrateSchemaCommand implements CliCommandInterface
{
    public function name(): string
    {
        return 'migrate:schema';
    }

    /**
     * @param array<int, string> $args
     */
    public function run(array $args = []): string
    {
        $schema = ['schema' => ['version' => '2.0']];
        $migrated = (new SchemaMigrator([new V20ToV21SchemaMigration()]))->migrate($schema, '2.1');
        return json_encode($migrated, JSON_PRETTY_PRINT) ?: '{}';
    }
}
