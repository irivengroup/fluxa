<?php
declare(strict_types=1);

namespace Iriven\Fluxa\Application\Cli;

use Iriven\Fluxa\Application\Profiling\Profiler;

/** @api */
final class DebugProfileCommand implements CliCommandInterface
{
    public function name(): string
    {
        return 'debug:profile';
    }

    /**
     * @param array<int, string> $args
     */
    public function run(array $args = []): string
    {
        $profiler = new Profiler();
        $profiler->record('build', 1.2, 1024);
        $profiler->record('render', 0.4, 2048);

        return json_encode($profiler->report(), JSON_PRETTY_PRINT) ?: '{}';
    }
}
