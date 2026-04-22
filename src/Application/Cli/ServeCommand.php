<?php
declare(strict_types=1);

namespace Iriven\Fluxa\Application\Cli;

/** @api */
final class ServeCommand implements CliCommandInterface
{
    public function name(): string
    {
        return 'serve';
    }

    /**
     * @param array<int, string> $args
     */
    public function run(array $args = []): string
    {
        $port = $args[0] ?? '8080';
        return json_encode(['status' => 'ready', 'server' => 'fluxa', 'port' => (string) $port], JSON_PRETTY_PRINT) ?: '{}';
    }
}
