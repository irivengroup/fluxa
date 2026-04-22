<?php
declare(strict_types=1);

namespace Iriven\Fluxon\Tests;

use Iriven\Fluxon\Application\Profiling\Profiler;
use PHPUnit\Framework\TestCase;

final class ProfilerRegressionTest extends TestCase
{
    public function testEmptyProfilerStillReturnsStructuredReport(): void
    {
        $report = (new Profiler())->report();

        self::assertArrayHasKey('timeline', $report);
        self::assertArrayHasKey('steps_count', $report);
        self::assertArrayHasKey('peak_memory_bytes', $report);
        self::assertSame(0, $report['steps_count']);
    }

    public function testNegativeValuesAreNormalized(): void
    {
        $profiler = new Profiler();
        $profiler->record('bad', -1.0, -15);
        $report = $profiler->report();

        self::assertSame(0.0, $report['timeline'][0]['time_ms']);
        self::assertSame(0, $report['timeline'][0]['memory_bytes']);
    }
}
