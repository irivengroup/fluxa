<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Tests;

use Iriven\PhpFormGenerator\Application\FormFactory;
use Iriven\PhpFormGenerator\Application\FormRuntimeContext;
use Iriven\PhpFormGenerator\Application\FormSchemaManager;
use Iriven\PhpFormGenerator\Infrastructure\Schema\ArraySchemaExporter;
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
