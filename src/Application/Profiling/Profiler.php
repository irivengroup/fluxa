<?php
declare(strict_types=1);

namespace Iriven\Fluxon\Application\Profiling;

/** @api */
final class Profiler
{
    private ProfileTimeline $timeline;

    public function __construct(?ProfileTimeline $timeline = null)
    {
        $this->timeline = $timeline ?? new ProfileTimeline();
    }

    public function record(string $step, float $timeMs, int $memoryBytes = 0): void
    {
        $this->timeline->add($step, $timeMs >= 0 ? $timeMs : 0.0, $memoryBytes >= 0 ? $memoryBytes : 0);
    }

    /**
     * @return array<string, mixed>
     */
    public function report(): array
    {
        return [
            'timeline' => $this->timeline->all(),
            'steps_count' => $this->timeline->count(),
            'peak_memory_bytes' => memory_get_peak_usage(true),
        ];
    }

    public function isEmpty(): bool
    {
        return $this->timeline->isEmpty();
    }
}
