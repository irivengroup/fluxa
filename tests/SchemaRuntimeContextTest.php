<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\FormFactory;
use Iriven\Fluxa\Application\FormRuntimeContext;
use Iriven\Fluxa\Application\FormSchemaManager;
use Iriven\Fluxa\Infrastructure\Schema\ArraySchemaExporter;
use PHPUnit\Framework\TestCase;

final class SchemaRuntimeContextTest extends TestCase
{
    public function testSchemaExportCanIncludeRuntimeMetadata(): void
    {
        $builder = (new FormFactory())->createBuilder('contact', null, ['method' => 'POST']);
        $builder->add('name', 'TextType');
        $form = $builder->getForm();

        $runtime = new FormRuntimeContext($form, 'tailwind', 'RendererClass', ['variant' => 'compact']);
        $schema = (new FormSchemaManager(new ArraySchemaExporter()))->export($form, $runtime);

        self::assertArrayHasKey('runtime', $schema);
        self::assertSame('tailwind', $schema['runtime']['theme']);
    }
}
