<?php
declare(strict_types=1);

namespace Iriven\Fluxon\Tests;

use PHPUnit\Framework\TestCase;

final class ComposerAutoloadRegressionTest extends TestCase
{
    public function testFluxonNamespaceIsStable(): void
    {
        self::assertTrue(class_exists(\Iriven\Fluxon\Application\Profiling\Profiler::class));
        self::assertTrue(class_exists(\Iriven\Fluxon\Application\Diagnostics\DiagnosticsRunner::class));
    }
}
