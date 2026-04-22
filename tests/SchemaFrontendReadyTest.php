<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\FormFactory;
use Iriven\Fluxa\Application\FormRuntimeContext;
use Iriven\Fluxa\Application\FormSchemaManager;
use Iriven\Fluxa\Infrastructure\Schema\ArraySchemaExporter;
use PHPUnit\Framework\TestCase;

final class SchemaFrontendReadyTest extends TestCase
{
    public function testSchemaIncludesUiAndPayloadMetadata(): void
    {
        $builder = (new FormFactory())->createBuilder('contact');
        $builder->add('name', 'TextType');
        $form = $builder->getForm();

        $context = new FormRuntimeContext($form, 'tailwind', 'RendererClass', ['variant' => 'compact']);
        $schema = (new FormSchemaManager(new ArraySchemaExporter()))->export($form, $context);

        self::assertArrayHasKey('runtime', $schema);
        self::assertArrayHasKey('payload', $schema['runtime']);
        self::assertArrayHasKey('ui', $schema);
        self::assertSame('compact', $schema['ui']['variant']);
    }
}
