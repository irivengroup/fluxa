<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Application\Schema;

/**
 * @api
 */
interface SchemaMigrationInterface
{
    public function fromVersion(): string;
    public function toVersion(): string;

    /**
     * @param array<string, mixed> $schema
     * @return array<string, mixed>
     */
    public function migrate(array $schema): array;
}
