<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Tests;

use Iriven\PhpFormGenerator\Application\Cli\DebugRuntimeCommand;
use Iriven\PhpFormGenerator\Application\Cli\DebugSchemaCommand;
use Iriven\PhpFormGenerator\Application\FormFactory;
use Iriven\PhpFormGenerator\Application\FormPluginKernel;
use Iriven\PhpFormGenerator\Application\FormSchemaManager;
use Iriven\PhpFormGenerator\Infrastructure\Schema\ArraySchemaExporter;
use PHPUnit\Framework\TestCase;

final class DebugCliRegressionTest extends TestCase
{
    public function testDebugSchemaReturnsValidJson(): void
    {
        $form = (new FormFactory())->createBuilder('contact')->getForm();
        $output = (new DebugSchemaCommand(new FormSchemaManager(new ArraySchemaExporter()), $form))->run();

        self::assertNotFalse(json_decode($output, true));
    }

    public function testDebugRuntimeReturnsValidJson(): void
    {
        $output = (new DebugRuntimeCommand(new FormPluginKernel()))->run();

        self::assertNotFalse(json_decode($output, true));
    }
}
