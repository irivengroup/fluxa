<?php
declare(strict_types=1);

namespace Iriven\Fluxa\Tests;

use Iriven\Fluxa\Application\Diagnostics\DiagnosticsRunner;
use PHPUnit\Framework\TestCase;

final class DiagnosticsRunnerTest extends TestCase
{
    public function testDiagnosticsRunnerReturnsStructuredReport(): void
    {
        $report = (new DiagnosticsRunner())->run();

        self::assertSame('ok', $report['status']);
        self::assertArrayHasKey('performance', $report);
        self::assertArrayHasKey('issues', $report);
    }
}
