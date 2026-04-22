<?php
declare(strict_types=1);

namespace Iriven\Fluxon\Tests;

use Iriven\Fluxon\Application\Diagnostics\DiagnosticsRunner;
use PHPUnit\Framework\TestCase;

final class DiagnosticsRunnerRegressionTest extends TestCase
{
    public function testDiagnosticsWithoutIssuesStayStructured(): void
    {
        $report = (new DiagnosticsRunner())->run();

        self::assertSame('ok', $report['status']);
        self::assertSame([], $report['issues']);
        self::assertSame([], $report['warnings']);
        self::assertArrayHasKey('performance', $report);
    }
}
