<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\FormFactory;
use Iriven\Fluxa\Application\FormSchemaManager;
use Iriven\Fluxa\Application\Frontend\FrontendFrameworkPresets;
use Iriven\Fluxa\Application\Frontend\FrontendSdk;
use Iriven\Fluxa\Infrastructure\Schema\ArraySchemaExporter;
use PHPUnit\Framework\TestCase;

final class FrontendSdkMaintenanceTest extends TestCase
{
    public function testSchemaIsNormalizedWhenRuntimeContextIsNull(): void
    {
        $form = (new FormFactory())->createBuilder('contact')->getForm();
        $sdk = new FrontendSdk(new FormSchemaManager(new ArraySchemaExporter()), FrontendFrameworkPresets::react());

        $schema = $sdk->buildSchema($form, null);

        self::assertArrayHasKey('form', $schema);
        self::assertArrayHasKey('fields', $schema);
        self::assertArrayHasKey('ui', $schema);
        self::assertArrayHasKey('runtime', $schema);
        self::assertArrayHasKey('validation', $schema);
    }

    public function testPayloadIsNormalizedWhenDataIsEmpty(): void
    {
        $form = (new FormFactory())->createBuilder('contact')->getForm();
        $sdk = new FrontendSdk(new FormSchemaManager(new ArraySchemaExporter()), FrontendFrameworkPresets::vue());

        $payload = $sdk->buildSubmissionPayload($form, []);

        self::assertSame([], $payload['payload']);
    }
}
