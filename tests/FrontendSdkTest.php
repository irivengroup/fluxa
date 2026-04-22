<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\FormFactory;
use Iriven\Fluxa\Application\FormRuntimeContext;
use Iriven\Fluxa\Application\FormSchemaManager;
use Iriven\Fluxa\Application\Frontend\FrontendFrameworkPresets;
use Iriven\Fluxa\Application\Frontend\FrontendSdk;
use Iriven\Fluxa\Infrastructure\Schema\ArraySchemaExporter;
use PHPUnit\Framework\TestCase;

final class FrontendSdkTest extends TestCase
{
    public function testSdkBuildsSchemaWithSdkMetadata(): void
    {
        $builder = (new FormFactory())->createBuilder('contact', null, ['method' => 'POST']);
        $builder->add('name', 'TextType', ['required' => true]);
        $form = $builder->getForm();

        $runtime = new FormRuntimeContext($form, 'tailwind', 'RendererClass', ['variant' => 'compact']);
        $sdk = new FrontendSdk(new FormSchemaManager(new ArraySchemaExporter()), FrontendFrameworkPresets::react());

        $schema = $sdk->buildSchema($form, $runtime);

        self::assertArrayHasKey('sdk', $schema);
        self::assertSame('react', $schema['sdk']['framework']);
        self::assertSame('1.0', $schema['sdk']['schema_version']);
    }

    public function testSdkBuildsSubmissionPayload(): void
    {
        $form = (new FormFactory())->createBuilder('contact')->getForm();
        $sdk = new FrontendSdk(new FormSchemaManager(new ArraySchemaExporter()), FrontendFrameworkPresets::vue());

        $payload = $sdk->buildSubmissionPayload($form, ['name' => 'Alice']);

        self::assertSame('contact', $payload['form']);
        self::assertSame(['name' => 'Alice'], $payload['payload']);
        self::assertSame('vue', $payload['sdk']['framework']);
    }
}
