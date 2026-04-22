<?php
declare(strict_types=1);

namespace Iriven\Fluxon\Tests;

use Iriven\Fluxon\Application\Profiling\ProfileTimeline;
use PHPUnit\Framework\TestCase;

final class ProfileTimelineRegressionTest extends TestCase
{
    public function testTimelineCanBeEmpty(): void
    {
        $timeline = new ProfileTimeline();

        self::assertTrue($timeline->isEmpty());
        self::assertSame(0, $timeline->count());
        self::assertSame([], $timeline->all());
    }

    public function testNegativeMemoryIsNormalized(): void
    {
        $timeline = new ProfileTimeline();
        $timeline->add('build', 1.0, -10);

        self::assertSame(0, $timeline->all()[0]['memory_bytes']);
    }
}
