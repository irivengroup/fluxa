<?php
declare(strict_types=1);

namespace Iriven\Fluxa\Application\Cli;

/** @api */
final class DebugHealthCommand implements CliCommandInterface
{
    public function name(): string
    {
        return 'debug:health';
    }

    /**
     * @param array<int, string> $args
     */
    public function run(array $args = []): string
    {
        return json_encode([
            'status' => 'ok',
            'service' => 'fluxa',
        ], JSON_PRETTY_PRINT) ?: '{}';
    }
}
