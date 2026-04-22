<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\FormFactory;
use Iriven\Fluxa\Application\FormHookKernel;
use Iriven\Fluxa\Application\FormSchemaManager;
use Iriven\Fluxa\Infrastructure\Schema\ArraySchemaExporter;
use Iriven\Fluxa\Tests\Fixtures\Hook\AfterSchemaExportHook;
use Iriven\Fluxa\Tests\Fixtures\Hook\BeforeSchemaExportHook;
use PHPUnit\Framework\TestCase;

final class SchemaRuntimeTest extends TestCase
{
    public function testBuilderFormSchemaCanBeExported(): void
    {
        $factory = new FormFactory();
        $builder = $factory->createBuilder('contact', null, ['method' => 'POST']);
        $builder->add('name', 'TextType', ['label' => 'Name', 'required' => true]);
        $builder->add('email', 'EmailType', ['label' => 'Email']);
        $form = $builder->getForm();

        $schema = (new FormSchemaManager(new ArraySchemaExporter()))->export($form);

        self::assertSame('contact', $schema['name']);
        self::assertSame('POST', $schema['method']);
        self::assertArrayHasKey('name', $schema['fields']);
        self::assertSame(true, $schema['fields']['name']['required']);
    }

    public function testSchemaExportHooksAreDispatched(): void
    {
        $hooks = (new FormHookKernel())
            ->register(new BeforeSchemaExportHook())
            ->register(new AfterSchemaExportHook());

        $factory = new FormFactory(hookKernel: $hooks);
        $builder = $factory->createBuilder('contact');
        $builder->add('name', 'TextType');
        $form = $builder->getForm();

        $schema = (new FormSchemaManager(new ArraySchemaExporter(), $hooks))->export($form);

        self::assertArrayHasKey('fields', $schema);
        self::assertArrayHasKey('_form', $form->getErrors());
        self::assertContains('Before schema export hook reached.', $form->getErrors()['_form']);
        self::assertContains('After schema export hook reached.', $form->getErrors()['_form']);
    }
}
