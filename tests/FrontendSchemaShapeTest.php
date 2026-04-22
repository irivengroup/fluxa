<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\FormFactory;
use Iriven\Fluxa\Application\FormSchemaManager;
use Iriven\Fluxa\Application\Frontend\FrontendSdk;
use Iriven\Fluxa\Infrastructure\Schema\ArraySchemaExporter;
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
