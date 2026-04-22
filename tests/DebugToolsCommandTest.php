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

final class DebugToolsCommandTest extends TestCase
{
    public function testDebugSchemaReturnsJson(): void
    {
        $form = (new FormFactory())->createBuilder('contact')->getForm();
        $output = (new DebugSchemaCommand(new FormSchemaManager(new ArraySchemaExporter()), $form))->run();

        self::assertStringContainsString('{', $output);
    }

    public function testDebugRuntimeReturnsJson(): void
    {
        $output = (new DebugRuntimeCommand(new FormPluginKernel()))->run();

        self::assertStringContainsString('plugins', $output);
        self::assertStringContainsString('extensions', $output);
    }
}
