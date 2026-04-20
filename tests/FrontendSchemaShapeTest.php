<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Tests;

use Iriven\PhpFormGenerator\Application\FormFactory;
use Iriven\PhpFormGenerator\Application\FormSchemaManager;
use Iriven\PhpFormGenerator\Application\Frontend\FrontendSdk;
use Iriven\PhpFormGenerator\Infrastructure\Schema\ArraySchemaExporter;
use PHPUnit\Framework\TestCase;

final class FrontendSchemaShapeTest extends TestCase
{
    public function testFieldContainsExpectedFrontendKeys(): void
    {
        $builder = (new FormFactory())->createBuilder('contact');
        $builder->add('name', 'TextType');
        $form = $builder->getForm();

        $schema = (new FrontendSdk(new FormSchemaManager(new ArraySchemaExporter())))->buildSchema($form);

        self::assertSame(
            ['name', 'type', 'component', 'props', 'label', 'required', 'choices', 'layout', 'ui_hints'],
            array_keys($schema['fields'][0])
        );
    }
}
