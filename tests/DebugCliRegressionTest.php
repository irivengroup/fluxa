<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\Cli\DebugRuntimeCommand;
use Iriven\Fluxa\Application\Cli\DebugSchemaCommand;
use Iriven\Fluxa\Application\FormFactory;
use Iriven\Fluxa\Application\FormPluginKernel;
use Iriven\Fluxa\Application\FormSchemaManager;
use Iriven\Fluxa\Infrastructure\Schema\ArraySchemaExporter;
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
