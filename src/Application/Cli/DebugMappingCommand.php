<?php
declare(strict_types=1);
namespace Iriven\Fluxa\Application\Cli;
use Iriven\Fluxa\Application\Mapping\FormHydrator;
/** @api */
final class DebugMappingCommand implements CliCommandInterface
{
    public function name(): string { return 'debug:mapping'; }
    /** @param array<int, string> $args */
    public function run(array $args = []): string
    {
        return json_encode((new FormHydrator())->hydrate(['email' => 'john@example.com']), JSON_PRETTY_PRINT) ?: '{}';
    }
}
