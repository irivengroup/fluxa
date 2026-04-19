<?php

declare(strict_types=1);

namespace Iriven\PhpFormGenerator\Tests;

use Iriven\PhpFormGenerator\Application\Cli\CliApplication;
use Iriven\PhpFormGenerator\Application\Cli\MakeFormCommand;
use Iriven\PhpFormGenerator\Application\Cli\MakePluginCommand;
use PHPUnit\Framework\TestCase;

final class CliRegressionTest extends TestCase
{
    public function testCommandsListIsSorted(): void
    {
        $cli = new CliApplication([new MakePluginCommand(), new MakeFormCommand()]);

        self::assertSame(['make:form', 'make:plugin'], $cli->commands());
    }

    public function testMakeFormFallsBackToDefaultName(): void
    {
        $output = (new MakeFormCommand())->run([]);

        self::assertStringContainsString('GeneratedFormType', $output);
    }

    public function testMakePluginFallsBackToDefaultName(): void
    {
        $output = (new MakePluginCommand())->run([]);

        self::assertStringContainsString('GeneratedPlugin', $output);
    }
}
