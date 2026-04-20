<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Tests;

use Iriven\PhpFormGenerator\Application\FormFactory;
use Iriven\PhpFormGenerator\Application\FormSchemaManager;
use Iriven\PhpFormGenerator\Infrastructure\Schema\ArraySchemaExporter;
use PHPUnit\Framework\TestCase;

final class SchemaCompatibilityRegressionTest extends TestCase
{
    public function testHeadlessSchemaRemainsVersioned(): void
    {
        $form = (new FormFactory())->createBuilder('contact')->getForm();
        $schema = (new FormSchemaManager(new ArraySchemaExporter()))->exportHeadless($form);
        self::assertSame('2.1', $schema['schema']['version']);
    }
}
