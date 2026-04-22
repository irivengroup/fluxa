<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\FormFactory;
use Iriven\Fluxa\Application\FormRenderManager;
use Iriven\Fluxa\Application\FormRuntimeContext;
use Iriven\Fluxa\Application\FormRuntimePipeline;
use Iriven\Fluxa\Application\FormSchemaManager;
use Iriven\Fluxa\Application\FormThemeKernel;
use Iriven\Fluxa\Infrastructure\Schema\ArraySchemaExporter;
use Iriven\Fluxa\Presentation\Html\HtmlRendererFactory;
use PHPUnit\Framework\TestCase;

final class RuntimeStaticShapeTest extends TestCase
{
    public function testRenderManagerAcceptsStructuredMetadata(): void
    {
        $builder = (new FormFactory())->createBuilder('contact');
        $builder->add('name', 'TextType');

        $manager = new FormRenderManager(new HtmlRendererFactory(new FormThemeKernel()));
        $html = $manager->render($builder->getForm(), 'default', ['variant' => 'compact', 'debug' => true]);

        self::assertIsString($html);
        self::assertStringContainsString('<form', $html);
    }

    public function testRuntimeContextMetadataRoundTrip(): void
    {
        $form = (new FormFactory())->createBuilder('contact')->getForm();
        $context = new FormRuntimeContext($form, 'tailwind', 'RendererClass', ['variant' => 'compact']);

        self::assertSame(['variant' => 'compact'], $context->metadata());
    }

    public function testSchemaManagerExportsRuntimeMetadataShape(): void
    {
        $builder = (new FormFactory())->createBuilder('contact');
        $builder->add('name', 'TextType');
        $form = $builder->getForm();

        $context = new FormRuntimeContext($form, 'default', 'RendererClass', ['variant' => 'compact']);
        $schema = (new FormSchemaManager(new ArraySchemaExporter()))->export($form, $context);

        self::assertArrayHasKey('runtime', $schema);
        self::assertIsArray($schema['runtime']);
        self::assertSame('default', $schema['runtime']['theme']);
    }

    public function testRuntimePipelineStagesRemainStable(): void
    {
        self::assertSame(
            ['before_build','after_build','before_submit','after_submit','before_render','after_render','before_export','after_export'],
            (new FormRuntimePipeline())->stages()
        );
    }
}
