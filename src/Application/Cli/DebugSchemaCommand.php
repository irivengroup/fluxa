<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Application\Cli;

use Iriven\Fluxa\Application\FormSchemaManager;
use Iriven\Fluxa\Domain\Form\Form;

/**
 * @api
 */
final class DebugSchemaCommand implements CliCommandInterface
{
    public function __construct(
        private readonly FormSchemaManager $schemaManager,
        private readonly Form $form,
    ) {
    }

    public function name(): string
    {
        return 'debug:schema';
    }

    /**
     * @param array<int, string> $args
     */
    public function run(array $args = []): string
    {
        $json = json_encode($this->schemaManager->exportHeadless($this->form), JSON_PRETTY_PRINT);

        return is_string($json) && $json !== '' ? $json : '{}';
    }
}
