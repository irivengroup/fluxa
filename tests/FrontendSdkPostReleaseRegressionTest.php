<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\FormFactory;
use Iriven\Fluxa\Application\FormSchemaManager;
use Iriven\Fluxa\Application\Frontend\FrontendSdk;
use Iriven\Fluxa\Application\Frontend\FrontendSdkConfig;
use Iriven\Fluxa\Infrastructure\Schema\ArraySchemaExporter;
use PHPUnit\Framework\TestCase;

final class FrontendSdkPostReleaseRegressionTest extends TestCase
{
    public function testSdkPublicAccessorsRemainStable(): void
    {
        $sdk = new FrontendSdk(
            new FormSchemaManager(new ArraySchemaExporter()),
            new FrontendSdkConfig('generic', '2.0')
        );

        self::assertSame('generic', $sdk->getFramework());
        self::assertSame('2.0', $sdk->getSchemaVersion());
    }

    public function testSdkSchemaContainsSdkMetadataPostRelease(): void
    {
        $form = (new FormFactory())->createBuilder('contact')->getForm();
        $sdk = new FrontendSdk(new FormSchemaManager(new ArraySchemaExporter()));

        $schema = $sdk->buildSchema($form);

        self::assertArrayHasKey('sdk', $schema);
        self::assertSame('2.0', $schema['sdk']['schema_version']);
    }
}
