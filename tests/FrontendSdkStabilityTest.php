<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\FormFactory;
use Iriven\Fluxa\Application\FormSchemaManager;
use Iriven\Fluxa\Application\Frontend\FrontendSdk;
use Iriven\Fluxa\Infrastructure\Schema\ArraySchemaExporter;
use PHPUnit\Framework\TestCase;

final class FrontendSdkStabilityTest extends TestCase
{
    public function testSchemaContainsStableTopLevelKeys(): void
    {
        $form = (new FormFactory())->createBuilder('contact')->getForm();
        $schema = (new FrontendSdk(new FormSchemaManager(new ArraySchemaExporter())))->buildSchema($form);

        self::assertSame(
            ['form', 'fields', 'ui', 'runtime', 'validation', 'schema', 'sdk'],
            array_keys($schema)
        );
    }

    public function testSchemaAlwaysContainsSdkAndSchemaNodes(): void
    {
        $form = (new FormFactory())->createBuilder('contact')->getForm();
        $schema = (new FrontendSdk(new FormSchemaManager(new ArraySchemaExporter())))->buildSchema($form);

        self::assertArrayHasKey('schema', $schema);
        self::assertArrayHasKey('sdk', $schema);
    }
}
